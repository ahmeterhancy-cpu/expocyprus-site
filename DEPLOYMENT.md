# 🚀 cPanel Deployment Guide

## Ön Gereksinimler

| Gereksinim | Minimum |
|---|---|
| **PHP** | 8.1+ (8.3 önerilir) |
| **MySQL** | 8.0+ |
| **Composer** | 2.x (cPanel'de kurulu olmalı) |
| **Git** | cPanel "Git Version Control" eklentisi |
| **PHP Uzantıları** | pdo_mysql, mbstring, json, fileinfo, gd/imagick |
| **Disk** | Min 500 MB (uploads dahil) |

---

## 📋 ADIM 1 — GitHub'a Yükle

### 1.1. GitHub'da yeni repo oluştur
- https://github.com/new
- Repo adı: `expocyprus-site` (veya istediğin isim)
- **Private** seçilebilir (production için önerilir)
- README, .gitignore, license **EKLEMEYIN** (zaten var)

### 1.2. Local'de git başlat ve push et

```bash
cd /path/to/expocyprus-site

# İlk kez ise
git init
git branch -M main
git add .
git commit -m "Initial commit — Expo Cyprus site"
git remote add origin https://github.com/KULLANICI/expocyprus-site.git
git push -u origin main
```

> ⚠️ **`.env` dosyası push EDİLMEZ** (`.gitignore`'da). Production secret'ları sadece sunucuda olur.

---

## 📋 ADIM 2 — cPanel: MySQL Veritabanı Oluştur

1. cPanel → **MySQL® Databases**
2. **Create New Database**
   - Name: `expocyprus` → tam adı `cpaneluser_expocyprus` olur
3. **MySQL Users → Add New User**
   - Username: `dbuser` → `cpaneluser_dbuser`
   - **Strong password** oluşturun (1Password / Bitwarden)
4. **Add User to Database**
   - User: `cpaneluser_dbuser`, DB: `cpaneluser_expocyprus`
   - **ALL PRIVILEGES** ✓

> 📝 Kayıt: DB adı, kullanıcı adı, şifre — ADIM 5'te `.env`'ye yazacağız.

---

## 📋 ADIM 3 — cPanel: Subdomain veya Domain Ayarla

### Seçenek A: Ana domain (`expocyprus.com`)
- cPanel → **Domains** — zaten kurulu olmalı
- Document Root: `public_html`

### Seçenek B: Subdomain (`new.expocyprus.com`)
- cPanel → **Subdomains** → Create
- Document Root: `public_html/new` (otomatik dolar)

---

## 📋 ADIM 4 — cPanel: Git Version Control

1. cPanel → **Git Version Control** → **Create**
2. **Clone URL**: `https://github.com/KULLANICI/expocyprus-site.git`
   - Private repo ise **Personal Access Token** kullanın:
     `https://USERNAME:TOKEN@github.com/USERNAME/expocyprus-site.git`
3. **Repository Path**: `/home/cpaneluser/expocyprus.com`
4. **Repository Name**: `expocyprus-site`
5. **Create** — repo clone edilecek

> ✅ Repo `~/expocyprus.com/` altında, `.cpanel.yml` deployment hook olarak kullanılır.

---

## 📋 ADIM 5 — `.env` Dosyasını Oluştur (cPanel File Manager)

1. cPanel → **File Manager**
2. `/home/cpaneluser/expocyprus.com/` dizinine git
3. `.env.example` dosyasını **Copy** → `.env` olarak yeniden adlandır
4. `.env` dosyasını **Edit** ile aç ve şu alanları DOLDUR:

```dotenv
APP_ENV=production
APP_URL=https://expocyprus.com
APP_DEBUG=false
APP_SECRET=                    # 64 karakter random hex (aşağıda)

DB_HOST=localhost
DB_NAME=cpaneluser_expocyprus
DB_USER=cpaneluser_dbuser
DB_PASS=ADIMs3'TEKI_PAROLA

MAIL_HOST=mail.expocyprus.com
MAIL_PORT=587
MAIL_USER=info@expocyprus.com
MAIL_PASS=EMAIL_PAROLASI

DEPLOY_WEBHOOK_SECRET=         # 32 karakter random (aşağıda)
DEPLOY_BRANCH=main
```

### Random secret üretmek için (cPanel Terminal'de)
```bash
php -r "echo bin2hex(random_bytes(32));"  # APP_SECRET için
php -r "echo bin2hex(random_bytes(16));"  # DEPLOY_WEBHOOK_SECRET için
```

---

## 📋 ADIM 6 — Composer ve Migration (cPanel Terminal)

1. cPanel → **Terminal** (veya SSH)
2. Komutları çalıştır:

```bash
cd ~/expocyprus.com

# Composer dependencies
composer install --no-dev --optimize-autoloader

# DB tablolarını oluştur
php database/migrate.php
```

Çıktı:
```
✓ DB connected
✓ Base schema applied
✓ CmsPage — CMS pages + settings
✓ CatalogCategory — Catalog categories
... (ve diğerleri)
✓ Migration complete
```

---

## 📋 ADIM 7 — `public_html`'e Public Dosyaları Kopyala

cPanel **File Manager** veya **Terminal**:

```bash
# Tüm public/ içeriğini public_html'e kopyala
cp -R ~/expocyprus.com/public/. ~/public_html/

# İzinleri ayarla
chmod -R 755 ~/public_html
chmod -R 775 ~/expocyprus.com/storage
chmod -R 775 ~/public_html/uploads
```

> 💡 Alternatif: `.cpanel.yml` Pull or Deploy butonu bunu otomatik yapar.

---

## 📋 ADIM 8 — İlk Deploy'u Tetikle

cPanel → **Git Version Control** → repo'nun yanındaki **Manage** → **Pull or Deploy**:

1. **Update from Remote** (en son git push'u çeker)
2. **Deploy HEAD Commit** (`.cpanel.yml`'i çalıştırır)

Başarılıysa:
- Source: `~/expocyprus.com/`
- Web root: `~/public_html/`
- Site: https://expocyprus.com 🎉

---

## 📋 ADIM 9 — Admin Kullanıcı Oluştur

cPanel **phpMyAdmin** → `cpaneluser_expocyprus` → SQL sekmesi:

```sql
INSERT INTO admin_users (name, email, password_hash, role, status, created_at, updated_at)
VALUES (
    'Admin',
    'admin@expocyprus.com',
    '$2y$10$YOUR_BCRYPT_HASH_HERE',
    'admin',
    'active',
    NOW(),
    NOW()
);
```

Bcrypt hash üretmek için (Terminal'de):
```bash
php -r "echo password_hash('SizinSifreniz123!', PASSWORD_BCRYPT);"
```

Hash'i kopyalayıp yukarıdaki SQL'e yapıştırın.

İlk giriş: `https://expocyprus.com/admin/login`

---

## 📋 ADIM 10 — GitHub Auto-Deploy Webhook (Opsiyonel)

Her `git push` sonrası site otomatik güncellensin:

1. **GitHub Repo → Settings → Webhooks → Add webhook**
   - **Payload URL**: `https://expocyprus.com/deploy-webhook.php`
   - **Content type**: `application/json`
   - **Secret**: `.env`'deki `DEPLOY_WEBHOOK_SECRET` değeri
   - **Events**: ☑ Just the push event
   - **Active**: ✓

2. **Test**: Bir commit push et → webhook log'unda 200 OK görmen gerek
3. **Sunucuda log**: `~/expocyprus.com/storage/logs/deploy.log`

---

## 🔧 Sorun Giderme

### Site beyaz ekran / 500 hatası
1. `.env` → `APP_DEBUG=true` yap
2. Sayfayı yenile, hatayı oku
3. Düzelt → tekrar `false` yap

### "vendor/autoload.php not found"
- cPanel Terminal'de: `cd ~/expocyprus.com && composer install --no-dev`

### "DB connection failed"
- `.env`'deki `DB_NAME`, `DB_USER`, `DB_PASS` doğru mu kontrol et
- cPanel'de **MySQL Databases** → user-DB ilişkisi var mı?

### Upload klasörü yazma hatası
```bash
chmod -R 775 ~/public_html/uploads
chown -R cpaneluser:cpaneluser ~/public_html/uploads
```

### Webhook 401 hatası
- `.env`'deki `DEPLOY_WEBHOOK_SECRET` ile GitHub Webhook secret'ı **bire bir aynı** olmalı

### Logo / sayfa içerikleri görünmüyor
- Admin → **Site Ayarları** → logo upload + footer/header ayarları
- Admin → **Sayfa Düzenleyici** → her sayfa için içerik düzenle

---

## 🔄 Güncelleme Akışı (Webhook Aktif Değilse)

Lokal'de değişiklik:
```bash
git add .
git commit -m "Update: ..."
git push origin main
```

Sunucuda (cPanel Terminal):
```bash
cd ~/expocyprus.com
git pull origin main
composer install --no-dev    # composer.json değiştiyse
php database/migrate.php     # yeni tablo/kolon eklendiyse
cp -R public/. ~/public_html/
```

VEYA: cPanel Git Version Control → Manage → **Update from Remote** → **Deploy HEAD Commit**

---

## 📞 Destek

- README: [README.md](README.md)
- cPanel docs: https://docs.cpanel.net/cpanel/files/git-version-control/
- PHP errors: `~/expocyprus.com/storage/logs/`
- Deploy log: `~/expocyprus.com/storage/logs/deploy.log`
