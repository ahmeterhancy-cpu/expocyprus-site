-- ═══════════════════════════════════════════════════════════════
-- Expo Cyprus — Services seed (PRODUCTION)
-- ═══════════════════════════════════════════════════════════════
-- Çalıştırma:
--   mysql -u USER -p DBNAME < database/seed-services-prod.sql
-- veya phpMyAdmin → SQL sekmesi → bu dosyanın içeriğini yapıştır → Git
--
-- INSERT ... ON DUPLICATE KEY UPDATE kullanır → tekrar çalıştırılabilir.
-- Image path'leri .webp (repo'da olan dosyalar).
-- ═══════════════════════════════════════════════════════════════

INSERT INTO `services` (`slug`, `title_tr`, `title_en`, `summary_tr`, `summary_en`, `image`, `sort_order`, `status`) VALUES
('fuar-organizasyonu', 'Fuar Organizasyonu', 'Fair Organisation',
 'Kendi sektörel fuarlarımızı düzenleriz. Sizin fuarınızı da konseptten kuruluma A\'dan Z\'ye yönetiriz.',
 'We organise our own sector fairs. We manage your fair from concept to completion, A to Z.',
 '/assets/images/service-fair-org.webp', 1, 'active'),
('kongre-organizasyonu', 'Kongre Organizasyonu', 'Congress Organisation',
 'Akademik, tıbbi, kurumsal kongreler. Konuşmacı yönetiminden sosyal programa, tüm operasyon bizden.',
 'Academic, medical, corporate congresses. From speaker management to social programme, all operations from us.',
 '/assets/images/service-fair-org.webp', 2, 'active'),
('stand-tasarim-kurulum', 'Stand Tasarım & Kurulum', 'Stand Design & Build',
 'İç teknik ekibimizle 100+ stand kurulumu deneyimi. Modüler, özel yapım veya hibrit — markanıza özel tasarım.',
 '100+ stand installations with our in-house technical team. Modular, custom-built or hybrid — design tailored to your brand.',
 '/assets/images/service-stand-design.webp', 3, 'active'),
('fuar-katilim-danismanligi', 'Fuar Katılım Danışmanlığı', 'Exhibitor Consulting',
 'Fuara hazırlıksız gitmeyin. Stratejiden ROI hesabına, hazırlıktan sonrası takibe — yanınızdayız.',
 'Don\'t go to a fair unprepared. From strategy to ROI calculation, from preparation to follow-up — we\'re with you.',
 '/assets/images/service-consulting.webp', 4, 'active'),
('hostes-stand-gorevlisi', 'Hostes & Stand Görevlisi', 'Hostess & Stand Staff',
 'Eğitimli, profesyonel saha kadrosu. Karşılamadan demoya, ürün tanıtımından lead toplamaya.',
 'Trained, professional field staff. From welcoming to demos, product presentation to lead collection.',
 '/assets/images/service-logistics.webp', 5, 'active'),
('pr-tanitim', 'PR & Tanıtım', 'PR & Promotion',
 'Etkinlik öncesi-sırası-sonrası iletişim yönetimi. Basın bülteninden sosyal medyaya, tek elden.',
 'Communication management before, during and after the event. From press releases to social media, single-source.',
 '/assets/images/service-digital.webp', 6, 'active')
ON DUPLICATE KEY UPDATE
  `title_tr`    = VALUES(`title_tr`),
  `title_en`    = VALUES(`title_en`),
  `summary_tr`  = VALUES(`summary_tr`),
  `summary_en`  = VALUES(`summary_en`),
  `image`       = VALUES(`image`),
  `sort_order`  = VALUES(`sort_order`),
  `status`      = VALUES(`status`);
