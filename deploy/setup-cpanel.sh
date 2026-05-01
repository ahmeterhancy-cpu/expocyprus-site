#!/bin/bash
# ═══════════════════════════════════════════════════════════════
# Expo Cyprus — cPanel Turhost ilk kurulum script'i
# ═══════════════════════════════════════════════════════════════
# cPanel Terminal'de tek seferlik çalıştır:
#
#   wget https://raw.githubusercontent.com/ahmeterhancy-cpu/expocyprus-site/main/deploy/setup-cpanel.sh
#   chmod +x setup-cpanel.sh
#   ./setup-cpanel.sh
#
# Veya manuel:
#   bash <(curl -s ...)
# ═══════════════════════════════════════════════════════════════

set -e

# ─── Renkli çıktı ──────────────────────────────────────────────
GREEN='\033[0;32m'; RED='\033[0;31m'; YELLOW='\033[1;33m'; CYAN='\033[0;36m'; NC='\033[0m'
ok()   { echo -e "${GREEN}✓${NC} $1"; }
err()  { echo -e "${RED}✗${NC} $1"; }
info() { echo -e "${CYAN}→${NC} $1"; }
warn() { echo -e "${YELLOW}!${NC} $1"; }

echo -e "${CYAN}═══ Expo Cyprus — cPanel Setup ═══${NC}"
echo "User: $USER"
echo "Home: $HOME"
echo "Date: $(date)"
echo ""

# ─── 1. Yapılandırma ────────────────────────────────────────────
SRC_DIR="$HOME/expocyprus.com"
PUB_DIR="$HOME/public_html"
REPO_SSH="git@github.com:ahmeterhancy-cpu/expocyprus-site.git"
BRANCH="main"

info "Source dizini: $SRC_DIR"
info "Web root:      $PUB_DIR"
echo ""

# ─── 2. SSH key — deploy key kontrolü ──────────────────────────
SSH_KEY="$HOME/.ssh/expocyprus_deploy_key"
if [ ! -f "$SSH_KEY" ]; then
    warn "SSH deploy key bulunamadı: $SSH_KEY"
    warn "Lütfen önce deploy/expocyprus_deploy_key (private) dosyasını"
    warn "$SSH_KEY yoluna yükleyin (cPanel File Manager veya scp)."
    warn "Sonra: chmod 600 $SSH_KEY"
    exit 1
fi
chmod 600 "$SSH_KEY"
ok "SSH key bulundu ve izinler ayarlandı"

# SSH config — github.com için bu key'i kullan
mkdir -p "$HOME/.ssh"
chmod 700 "$HOME/.ssh"
if ! grep -q "expocyprus_deploy_key" "$HOME/.ssh/config" 2>/dev/null; then
    cat >> "$HOME/.ssh/config" <<EOF

Host github-expocyprus
    HostName github.com
    User git
    IdentityFile $SSH_KEY
    IdentitiesOnly yes
    StrictHostKeyChecking accept-new
EOF
    chmod 600 "$HOME/.ssh/config"
    ok "SSH config eklendi (github-expocyprus alias)"
fi

# Test SSH
if ssh -o BatchMode=yes -T github-expocyprus 2>&1 | grep -q "successfully authenticated"; then
    ok "GitHub SSH bağlantısı çalışıyor"
else
    warn "GitHub SSH testinde sorun olabilir (yine de devam ediyoruz)"
fi

# ─── 3. Repo clone / pull ──────────────────────────────────────
if [ ! -d "$SRC_DIR/.git" ]; then
    info "Repo clone ediliyor..."
    git clone "git@github-expocyprus:ahmeterhancy-cpu/expocyprus-site.git" "$SRC_DIR"
    ok "Clone tamamlandı"
else
    info "Repo mevcut, pull ediliyor..."
    cd "$SRC_DIR"
    git remote set-url origin "git@github-expocyprus:ahmeterhancy-cpu/expocyprus-site.git"
    git fetch --all
    git reset --hard "origin/$BRANCH"
    ok "Pull tamamlandı"
fi

cd "$SRC_DIR"

# ─── 4. Composer install ───────────────────────────────────────
if [ ! -f "$SRC_DIR/vendor/autoload.php" ]; then
    info "Composer install ediliyor..."
    if command -v composer >/dev/null 2>&1; then
        composer install --no-dev --optimize-autoloader 2>&1 | tail -5
    elif [ -f "/usr/local/bin/composer" ]; then
        /usr/local/bin/composer install --no-dev --optimize-autoloader 2>&1 | tail -5
    elif command -v ea-php83 >/dev/null 2>&1 && [ -f "$HOME/composer.phar" ]; then
        ea-php83 "$HOME/composer.phar" install --no-dev --optimize-autoloader 2>&1 | tail -5
    else
        warn "Composer bulunamadı! Manuel kurulum:"
        echo "  curl -sS https://getcomposer.org/installer | php"
        echo "  mv composer.phar ~/composer.phar"
        echo "  ea-php83 ~/composer.phar install --no-dev"
        exit 1
    fi
    ok "Composer dependencies yüklendi"
else
    info "vendor/ mevcut, atlandı"
fi

# ─── 5. .env dosyası ───────────────────────────────────────────
if [ ! -f "$SRC_DIR/.env" ]; then
    cp "$SRC_DIR/.env.example" "$SRC_DIR/.env"
    SECRET=$(php -r "echo bin2hex(random_bytes(32));")
    WEBHOOK=$(php -r "echo bin2hex(random_bytes(16));")
    sed -i "s|__GENERATE_A_RANDOM_32CHAR_HEX_STRING__|$SECRET|" "$SRC_DIR/.env"
    sed -i "s|__GENERATE_A_RANDOM_SECRET__|$WEBHOOK|" "$SRC_DIR/.env"
    sed -i "s|APP_URL=http://localhost/expocyprus-site/public|APP_URL=https://expocyprus.com|" "$SRC_DIR/.env"
    sed -i "s|APP_ENV=development|APP_ENV=production|" "$SRC_DIR/.env"
    sed -i "s|APP_DEBUG=true|APP_DEBUG=false|" "$SRC_DIR/.env"
    ok ".env oluşturuldu (random secret + production ayarları)"
    warn "DB_HOST / DB_NAME / DB_USER / DB_PASS değerlerini .env'de DOLDURUN!"
    echo "    nano $SRC_DIR/.env"
else
    info ".env mevcut, atlandı"
fi

# ─── 6. Storage / uploads dizinleri ────────────────────────────
mkdir -p "$SRC_DIR/storage/sessions" "$SRC_DIR/storage/cache" "$SRC_DIR/storage/logs"
chmod -R 775 "$SRC_DIR/storage"
ok "Storage dizinleri oluşturuldu (775 izin)"

# ─── 7. public/ → public_html'e kopyala ────────────────────────
info "Public dosyaları $PUB_DIR'a kopyalanıyor..."
mkdir -p "$PUB_DIR"
cp -R "$SRC_DIR/public/." "$PUB_DIR/"

# Uploads dizini için yazma izni
mkdir -p "$PUB_DIR/uploads"
chmod -R 775 "$PUB_DIR/uploads"
ok "Public dosyaları taşındı, uploads/ izinleri ayarlandı"

# ─── 8. Database migration ─────────────────────────────────────
if grep -q "__SET_DATABASE_PASSWORD__" "$SRC_DIR/.env" 2>/dev/null; then
    warn "DB ayarları .env'de henüz yapılmamış — migration ATLANIYOR"
    warn "Önce .env'yi düzenleyip sonra: php $SRC_DIR/database/migrate.php"
else
    info "DB tabloları oluşturuluyor..."
    if php "$SRC_DIR/database/migrate.php" 2>&1 | tail -10; then
        ok "Migration tamamlandı"
    else
        err "Migration başarısız — .env DB ayarlarını kontrol edin"
    fi
fi

echo ""
echo -e "${GREEN}═══ KURULUM TAMAMLANDI ═══${NC}"
echo ""
echo "Sıradaki adımlar:"
echo "  1. .env dosyasını düzenle:    nano $SRC_DIR/.env"
echo "     (DB_NAME, DB_USER, DB_PASS, MAIL_* alanları)"
echo "  2. Migration çalıştır:        php $SRC_DIR/database/migrate.php"
echo "  3. Admin user oluştur:        phpMyAdmin → SQL ile INSERT INTO admin_users ..."
echo "  4. Tarayıcıda aç:             https://expocyprus.com"
echo ""
echo "Auto-deploy webhook URL:"
echo "  https://expocyprus.com/deploy-webhook.php"
echo "  Secret: $(grep DEPLOY_WEBHOOK_SECRET $SRC_DIR/.env | cut -d= -f2)"
echo ""
