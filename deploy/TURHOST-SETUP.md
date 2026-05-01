# 🇹🇷 Turhost cPanel — Hızlı Kurulum (expocyprus.com)

cPanel: https://srvc142.trwww.com:2083/
Domain: **expocyprus.com**
GitHub: https://github.com/ahmeterhancy-cpu/expocyprus-site (Private)

---

## 🚀 Adım 1: Veritabanı oluştur (5 dakika)

1. cPanel → **MySQL® Veritabanları**
2. **Yeni Veritabanı Oluştur**: `expocyprus` (sistem otomatik prefix ekler, örn. `kullaniciadi_expocyprus`)
3. **MySQL Kullanıcıları** → **Yeni Kullanıcı**:
   - Kullanıcı: `dbadmin` (otomatik prefix ile, örn. `kullaniciadi_dbadmin`)
   - **Güçlü şifre üret** ve KAYDET (1Password / not defteri)
4. **Veritabanına Kullanıcı Ekle**:
   - User: yeni oluşturduğun, DB: `kullaniciadi_expocyprus`
   - **TÜM İZİNLER** ✓ → Değişiklikleri Yap

📝 **Kayıt:** DB adı, kullanıcı adı, şifre — Adım 4'te kullanacağız.

---

## 🔑 Adım 2: Deploy SSH key — cPanel'a yükle (3 dakika)

GitHub'da private repo'yu cPanel'in SSH ile çekebilmesi için deploy key gerek.

### 2.1 Private key dosyasını cPanel File Manager'a yükle

1. **Local'inden** şu dosyayı bul: `C:\laragon\www\expocyprus-site\.deploy\expocyprus_deploy_key`
2. Bu dosyanın **içeriğini kopyala** (notepad ile aç, hepsini seç)
3. cPanel → **Terminal** (yoksa **File Manager** → **+ File** ile oluştur):
   ```bash
   mkdir -p ~/.ssh
   chmod 700 ~/.ssh
   nano ~/.ssh/expocyprus_deploy_key
   # Yapıştır → Ctrl+X → Y → Enter
   chmod 600 ~/.ssh/expocyprus_deploy_key
   ```

### 2.2 SSH config

```bash
cat >> ~/.ssh/config <<'EOF'

Host github-expocyprus
    HostName github.com
    User git
    IdentityFile ~/.ssh/expocyprus_deploy_key
    IdentitiesOnly yes
    StrictHostKeyChecking accept-new
EOF
chmod 600 ~/.ssh/config

# Test:
ssh -T github-expocyprus
```

> Çıktı: `Hi ahmeterhancy-cpu/expocyprus-site! You've successfully authenticated...`

---

## ⚡ Adım 3: One-Shot Setup Script (5 dakika)

cPanel **Terminal**'de:

```bash
cd ~
git clone git@github-expocyprus:ahmeterhancy-cpu/expocyprus-site.git expocyprus.com
cd expocyprus.com
chmod +x deploy/setup-cpanel.sh
./deploy/setup-cpanel.sh
```

Script otomatik yapacak:
- ✅ Composer install (`vendor/`)
- ✅ `.env` oluşturma (random secret'larla)
- ✅ Storage dizinleri + izinleri (775)
- ✅ `public/` içeriğini `~/public_html/`'e kopyalar
- ✅ Migration çalıştırır (eğer DB ayarları doluysa)

---

## 📝 Adım 4: .env'yi düzenle (DB ayarları)

```bash
nano ~/expocyprus.com/.env
```

Şu satırları doldur:

```dotenv
DB_NAME=kullaniciadi_expocyprus     # Adım 1'deki DB adı
DB_USER=kullaniciadi_dbadmin        # Adım 1'deki kullanıcı
DB_PASS=Adim1deUrettiginParola       # Adım 1'deki şifre

MAIL_HOST=mail.expocyprus.com        # cPanel → E-posta hesapları'ndan
MAIL_USER=info@expocyprus.com        # Veya hangi e-posta'yı kullanıyorsan
MAIL_PASS=email_paroLasi
MAIL_FROM=info@expocyprus.com
```

**Kaydet**: `Ctrl+O` → `Enter` → `Ctrl+X`

---

## 🗄️ Adım 5: Migration + Admin kullanıcı (5 dakika)

```bash
# 5.1 — DB tablolarını oluştur (23 tablo)
cd ~/expocyprus.com
php database/migrate.php
```

Çıktı şöyle olmalı:
```
✓ DB connected
✓ CmsPage — CMS pages + settings
✓ Lead — Leads + activities + files
... (devamı)
✓ Migration complete
```

```bash
# 5.2 — Admin parola hash'i oluştur
php -r "echo password_hash('Sizin_Admin_Sifreniz_123!', PASSWORD_BCRYPT);"
```

> Çıktıdaki uzun `$2y$10$...` string'ini kopyala.

cPanel → **phpMyAdmin** → `kullaniciadi_expocyprus` veritabanı → **SQL** sekmesi:

```sql
INSERT INTO admin_users (name, email, password_hash, role, status, created_at, updated_at)
VALUES (
    'Admin',
    'admin@expocyprus.com',
    '$2y$10$BURAYA_HASH_YAPISTIR',
    'super_admin',
    'active',
    NOW(),
    NOW()
);
```

**Çalıştır** → 1 row affected.

---

## 🌐 Adım 6: Site açılıyor mu? (1 dakika)

Tarayıcıda aç: **https://expocyprus.com**

Eğer 500 hata gelirse:
```bash
nano ~/expocyprus.com/.env
# APP_DEBUG=false → APP_DEBUG=true yap
# Sayfayı yenile, hatayı oku
# Çözdükten sonra tekrar APP_DEBUG=false
```

Admin paneli: **https://expocyprus.com/admin/login**

---

## 🔁 Adım 7: GitHub Auto-Deploy (Webhook) — Opsiyonel

Her `git push origin main`'den sonra site otomatik güncellensin:

1. cPanel'da, `.env`'deki **DEPLOY_WEBHOOK_SECRET** değerini kopyala:
   ```bash
   grep DEPLOY_WEBHOOK_SECRET ~/expocyprus.com/.env
   ```

2. **GitHub Repo → Settings → Webhooks → Add webhook**:
   - **Payload URL**: `https://expocyprus.com/deploy-webhook.php`
   - **Content type**: `application/json`
   - **Secret**: yukarıda kopyaladığın değer
   - **Events**: ☑ Just the push event
   - **Active**: ✓

3. Test: bir commit push et → GitHub webhook log'unda yeşil tik görmen gerek
   ```bash
   tail -f ~/expocyprus.com/storage/logs/deploy.log
   ```

---

## 🖼️ Adım 8: Büyük asset görselleri yükle (10 dakika)

Repo'da olmayan ~120 MB görsel var (AI üretimi büyük PNG'ler).

### Yöntem A: cPanel File Manager (kolay)

1. Local'inde `C:\laragon\www\expocyprus-site\public\assets\images\` klasörünü **ZIP'le**:
   - `service-fair-org.png`, `service-logistics.png`, `hero-hall.png`, vs.
   - `hotels/` klasörü (içindeki tüm resimler)
   - `stand-models/` klasörü
   - `furniture/` klasörü
2. ZIP dosyasını cPanel **File Manager** → `~/public_html/assets/images/` altına yükle
3. **Right click → Extract**

### Yöntem B: SSH/SCP (hızlı)

Local'inde Windows PowerShell:
```powershell
# Önce ZIP yap
Compress-Archive -Path "C:\laragon\www\expocyprus-site\public\assets\images\*" `
                 -DestinationPath "C:\Users\ahmet\Desktop\images.zip"

# scp ile yükle (Turhost SSH erişimi varsa)
scp -P 22 -i C:\path\to\ssh\key C:\Users\ahmet\Desktop\images.zip kullaniciadi@srvc142.trwww.com:~/public_html/assets/

# Sonra cPanel Terminal'de:
cd ~/public_html/assets
unzip -o images.zip -d images/
```

---

## ✅ Kontrol Listesi

- [ ] DB oluşturuldu, kullanıcı atandı
- [ ] Deploy key cPanel'a yüklendi (`~/.ssh/expocyprus_deploy_key`)
- [ ] `setup-cpanel.sh` başarıyla çalıştı
- [ ] `.env` doğru DB / mail bilgileriyle düzenlendi
- [ ] `php database/migrate.php` başarılı (23 tablo)
- [ ] Admin kullanıcı oluşturuldu (phpMyAdmin SQL)
- [ ] **https://expocyprus.com** açılıyor
- [ ] **https://expocyprus.com/admin/login** ile giriş yapılıyor
- [ ] (Ops.) Webhook eklendi, deploy.log'da test çalışması var
- [ ] (Ops.) Büyük görseller yüklendi

---

## 🛟 Hata Durumunda

| Sorun | Çözüm |
|---|---|
| `vendor/autoload.php not found` | `cd ~/expocyprus.com && composer install --no-dev` |
| `Could not connect to database` | `.env`'deki DB_* değerleri doğru mu? Cpanel'da kullanıcı DB'ye atandı mı? |
| `500 Internal Server Error` | `.env` → `APP_DEBUG=true` yap, sayfayı yenile, hatayı gör, düzelt, geri kapat |
| Beyaz ekran | `tail -f ~/expocyprus.com/storage/logs/*.log` ile log oku |
| Permission denied (uploads) | `chmod -R 775 ~/public_html/uploads` |
| Webhook 401 | `.env` ve GitHub webhook secret AYNI mı? |
| Composer yok | `curl -sS https://getcomposer.org/installer | php; mv composer.phar ~/composer.phar` |

---

## 📞 Bana Ulaş

Bir adımda takılırsan:
1. Hatayı kopyala
2. Hangi adımdaysın yaz
3. cPanel kullanıcı adın (kullanıcıadı_xxx prefix'i için)
