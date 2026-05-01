# Expo Cyprus — UNIFEX Fuarcılık

Kıbrıs'ın en köklü fuar organizasyon firması Expo Cyprus için kurumsal web sitesi.

**Tech Stack:** PHP 8.1+ · MySQL 8 · Vanilla JS · Apple-style UI

## 🚀 Modüller

| Modül | URL |
|---|---|
| **Public Site** | `/` (anasayfa, hakkımızda, hizmetler, fuarlar, blog, vb.) |
| **Üye Portalı** | `/uye/giris` (firma siparişlerini takip eder) |
| **Admin Paneli** | `/admin/login` |
| **CMS Sayfa Düzenleyici** | `/admin/cms` (24 sayfa + Block Builder) |
| **CRM (Lead)** | `/admin/leads` (Pipedrive tarzı pipeline) |
| **Üretim Yönetimi** | `/admin/production-orders` (9-aşamalı pipeline) |
| **Crew Başvurular** | `/admin/crew` (saha kadrosu) |
| **Site Ayarları** | `/admin/cms/settings` (logo, footer, social, GA4, FB Pixel) |

## 📋 Özellikler

- **Çift dil** (TR/EN) tüm sayfalar
- **24 düzenlenebilir CMS sayfası** + Elementor tarzı Block Builder
- **Apple-tarzı 3D animasyonlu sayfalar** (about, fairs, services)
- **9 aşamalı üretim takibi** (sipariş alındı → tasarım → üretim → kurulum → tamamlandı)
- **Lead CRM** — drag-drop kanban pipeline + Pipedrive metrikler
- **Çoklu dosya upload** (catalog, blog, lead, üretim, crew)
- **SEO altyapısı** — sitemap.xml, robots.txt, JSON-LD, hreflang, OG, Twitter
- **Mobil uyumlu** — touch targets, responsive grid, iOS optimizasyonları
- **Site Ayarları'ndan** GA4 / GTM / FB Pixel / GSC doğrulama tek tıkla

## 🛠️ Local Development

```bash
git clone https://github.com/USERNAME/expocyprus-site.git
cd expocyprus-site
composer install
cp .env.example .env
# .env'yi düzenleyin (DB bilgileri)

# DB tablolarını oluştur
php database/migrate.php

# Laragon ile çalıştır (veya php -S localhost:8000 -t public)
```

## 🌐 Production (cPanel) Deployment

Detaylı kurulum için → [DEPLOYMENT.md](DEPLOYMENT.md)

**Özet:**
1. cPanel **Git Version Control** → Repo URL: `https://github.com/USERNAME/expocyprus-site.git`
2. **Pull or Deploy** → cPanel `.cpanel.yml`'i çalıştırır
3. `database/migrate.php` ile tabloları kur
4. `.env`'yi production değerleriyle doldur (cPanel File Manager)
5. (Opsiyonel) GitHub Webhook → `/deploy-webhook.php` ile auto-deploy

## 📁 Dizin Yapısı

```
expocyprus-site/
├── config/          # Yapılandırma (database, routes)
├── database/        # SQL şema, seed scriptleri, migration runner
├── lang/            # TR/EN çeviriler
├── public/          # Web root — index.php, assets, uploads
│   ├── assets/      # CSS, JS, görseller
│   ├── uploads/     # Kullanıcı yüklemeleri (git'te yok)
│   ├── index.php    # Front controller
│   └── deploy-webhook.php  # GitHub auto-deploy
├── src/
│   ├── Controllers/ # Public + Admin controllers
│   ├── Core/        # Application, DB, View, Router, BlockRenderer, SEO
│   ├── Middleware/  # AuthMiddleware, MemberAuthMiddleware
│   └── Models/      # ActiveRecord-style models
├── storage/         # Sessions, cache, logs (git'te yok)
├── views/
│   ├── admin/       # Admin paneli view'ları
│   ├── layouts/     # main, admin, member, auth, blank
│   ├── pages/       # Public sayfalar (Apple-style)
│   └── partials/    # nav, footer, cookie-banner
├── .env.example     # Env template
├── .gitignore
├── .cpanel.yml      # cPanel auto-deploy hook
├── composer.json
└── README.md
```

## 🗄️ Veritabanı

- **MySQL 8.0+** (utf8mb4)
- **23 tablo** — admin_users, services, fairs, catalog_items, blog_posts, hotels, members, production_orders + (5 alt tablo), leads + (2 alt tablo), crew_applications, cms_pages, cms_settings, vb.
- Otomatik migration: `php database/migrate.php`

## 🔐 Güvenlik

- CSRF token tüm POST formlarında
- Bcrypt password hashing (admin + member)
- Session regenerate her 30 dakikada bir
- Webhook HMAC-SHA256 imza doğrulama
- Admin/üye route'ları middleware ile korumalı
- File upload whitelist + boyut sınırı

## 📜 Lisans

Proprietary — Expo Cyprus / UNIFEX Fuarcılık Organizasyon Ltd.
