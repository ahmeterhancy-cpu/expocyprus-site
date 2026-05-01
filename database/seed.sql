-- ═══════════════════════════════════════════════════════════════
-- Expo Cyprus — Seed Data
-- ═══════════════════════════════════════════════════════════════

-- Admin kullanıcısı (şifre: Admin1234! — production'da değiştirin!)
INSERT INTO `admin_users` (`name`, `email`, `password_hash`, `role`, `status`) VALUES
('Expo Cyprus Admin', 'admin@expocyprus.com',
 '$2y$12$nUtn3FdUOzNP6V6A49fAxOGbc61O.TCIxb2mHyr1AxpAkaI7hqN7y', -- password: password
 'admin', 'active');

-- Site ayarları
INSERT INTO `site_settings` (`key`, `value`) VALUES
('site_name',      'Expo Cyprus'),
('site_tagline',   'Her Detay. Tek Ekip. 22 Yıl Deneyim.'),
('site_email',     'info@expocyprus.com'),
('site_phone',     '+90 XXX XXX XX XX'),
('site_address',   'Lefkoşa, KKTC'),
('mail_from_name', 'Expo Cyprus'),
('mail_from',      'info@expocyprus.com');

-- 6 Hizmet
INSERT INTO `services` (`slug`, `title_tr`, `title_en`, `summary_tr`, `summary_en`, `sort_order`, `status`) VALUES
('fuar-organizasyonu', 'Fuar Organizasyonu', 'Fair Organisation',
 'Kendi sektörel fuarlarımızı düzenleriz. Sizin fuarınızı da konseptten kuruluma A\'dan Z\'ye yönetiriz.',
 'We organise our own sector fairs. We manage your fair from concept to completion, A to Z.',
 1, 'active'),
('kongre-organizasyonu', 'Kongre Organizasyonu', 'Congress Organisation',
 'Akademik, tıbbi, kurumsal kongreler. Konuşmacı yönetiminden sosyal programa, tüm operasyon bizden.',
 'Academic, medical, corporate congresses. From speaker management to social programme, all operations from us.',
 2, 'active'),
('stand-tasarim-kurulum', 'Stand Tasarım & Kurulum', 'Stand Design & Build',
 'İç teknik ekibimizle 100+ stand kurulumu deneyimi. Modüler, özel yapım veya hibrit — markanıza özel tasarım.',
 '100+ stand installations with our in-house technical team. Modular, custom-built or hybrid — design tailored to your brand.',
 3, 'active'),
('fuar-katilim-danismanligi', 'Fuar Katılım Danışmanlığı', 'Exhibitor Consulting',
 'Fuara hazırlıksız gitmeyin. Stratejiden ROI hesabına, hazırlıktan sonrası takibe — yanınızdayız.',
 'Don\'t go to a fair unprepared. From strategy to ROI calculation, from preparation to follow-up — we\'re with you.',
 4, 'active'),
('hostes-stand-gorevlisi', 'Hostes & Stand Görevlisi', 'Hostess & Stand Staff',
 'Eğitimli, profesyonel saha kadrosu. Karşılamadan demoya, ürün tanıtımından lead toplamaya.',
 'Trained, professional field staff. From welcoming to demos, product presentation to lead collection.',
 5, 'active'),
('pr-tanitim', 'PR & Tanıtım', 'PR & Promotion',
 'Etkinlik öncesi-sırası-sonrası iletişim yönetimi. Basın bülteninden sosyal medyaya, tek elden.',
 'Communication management before, during and after the event. From press releases to social media, single-source.',
 6, 'active');

-- 4 Fuar
INSERT INTO `fairs` (`slug`, `name_tr`, `name_en`, `summary_tr`, `summary_en`, `sort_order`, `status`) VALUES
('tuketici-fuari', 'Tüketici Fuarı', 'Consumer Fair',
 'Tüm Sektörler. Tek Çatı Altında.', 'All Sectors. Under One Roof.',
 1, 'active'),
('av-avcilik-atis-doga-sporlari-fuari',
 'Av, Avcılık, Atıcılık & Doğa Sporları Fuarı',
 'Hunting, Shooting & Outdoor Sports Fair',
 'Kıbrıs\'ın Tek İhtisas Fuarı.', 'Cyprus\'s Only Specialist Fair.',
 2, 'active'),
('tarim-hayvancilik-fuari', 'Tarım Hayvancılık Fuarı', 'Agriculture & Livestock Fair',
 'Kıbrıs Tarımının Buluşma Noktası.', 'The Meeting Point of Cyprus Agriculture.',
 3, 'active'),
('dugun-hazirliklari-fuari', 'Evlilik & Düğün Hazırlıkları Fuarı', 'Wedding Preparations Fair',
 'Hayallerinizdeki Düğün için Tüm Sektör Burada.', 'Every Sector for Your Dream Wedding is Here.',
 4, 'active');
