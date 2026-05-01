-- Stand Kataloğu — 9 hazır stand modeli
-- Kategoriler: bir-birim (3×2), iki-birim (6×2), uc-birim (9×2), ada (6×4)

INSERT INTO catalog_items
  (slug, model_no, name_tr, name_en, size_category, dimensions, price, currency,
   features_json, description, description_en, image_main, status)
VALUES

-- ── BİR BİRİM (3m × 2m) ──────────────────────────
('bb-01-modern-beyaz', 'BB-01', 'Modern Beyaz Stand', 'Modern White Stand',
 'bir-birim', '3m × 2m', 1850.00, 'EUR',
 JSON_ARRAY('Tek cephe açık', 'Beyaz minimal', 'LED aydınlatma', 'Karşılama desk', 'Logo paneli', 'Halı zemin'),
 'Tek cephe açık, kompakt 3×2m stand. Beyaz minimal estetiği ve krom aksanları ile küçük markaların ilk fuar deneyimi için ideal. Karşılama deski, logo paneli ve LED aydınlatma dahil.',
 'Single-side open compact 3×2m stand. Ideal for first-time exhibitors with white minimalist aesthetic and chrome accents. Includes reception desk, logo wall and integrated LED lighting.',
 '/assets/images/stand-models/BB-01.png', 'active'),

('bb-02-ahsap-koyu', 'BB-02', 'Ahşap Koyu Stand', 'Dark Wood Stand',
 'bir-birim', '3m × 2m', 2100.00, 'EUR',
 JSON_ARRAY('Tek cephe açık', 'Ceviz panel', 'Sıcak aydınlatma', 'Karşılama desk', 'Marka grafikleri', 'Halı zemin'),
 'Sıcak ceviz ahşap paneli ve marka grafikleri ile premium 3×2m kompakt stand. Spot ışıklandırma ve şık karşılama deski ile butik markalar için tasarlandı.',
 'Premium compact 3×2m stand with warm walnut paneling and brand graphics. Designed for boutique brands with spotlights and stylish reception desk.',
 '/assets/images/stand-models/BB-02.png', 'active'),

-- ── İKİ BİRİM (6m × 2m) ──────────────────────────
('ib-01-l-tipi-kavisli', 'IB-01', 'L Tipi Kavisli Beyaz', 'L-Type Curved White',
 'iki-birim', '6m × 2m', 3450.00, 'EUR',
 JSON_ARRAY('İki cephe açık (L)', 'Kavisli beyaz duvarlar', 'LED tavan aydınlatma', 'Geniş marka grafikleri', 'Karşılama bankosu', 'Ürün vitrini'),
 'L tipi (iki cephe açık) 6×2m stand. Kavisli beyaz duvarları, entegre LED tavan aydınlatması ve büyük marka grafikleri ile orta ölçek katılımcılar için modern çözüm.',
 'L-type (two sides open) 6×2m stand. Modern solution for mid-size exhibitors with curved white walls, integrated LED ceiling and large brand graphics.',
 '/assets/images/stand-models/IB-01.png', 'active'),

('ib-02-koyu-pano', 'IB-02', 'Koyu Pano Sistemi', 'Dark Panel System',
 'iki-birim', '6m × 2m', 3850.00, 'EUR',
 JSON_ARRAY('İki cephe açık', 'Koyu sleek paneller', 'Arkadan ışıklı logo', 'Toplantı alanı', 'Modern mobilya', 'Sofistike aydınlatma'),
 'İki cephe açık, koyu sleek panellerle premium 6×2m stand. Arkadan ışıklı logo duvarı, modern mobilyalı toplantı alanı ile profesyonel iş etkinlikleri için.',
 'Two-sided open premium 6×2m stand with dark sleek panels. Backlit logo wall and modern furnished meeting area — for professional business events.',
 '/assets/images/stand-models/IB-02.png', 'active'),

-- ── ÜÇ BİRİM (9m × 2m) ──────────────────────────
('ub-01-3-cephe-uzun', 'UB-01', '3 Cephe Uzun Stand', '3-Side Long Stand',
 'uc-birim', '9m × 2m', 5950.00, 'EUR',
 JSON_ARRAY('Üç cephe açık', 'Uzatılmış marka duvarı', 'Çoklu sergileme bölgesi', 'LED ekranlar', 'Merkezi karşılama', 'Kurumsal renk paleti'),
 'Üç cephe açık, 9 metre uzunluğunda büyük stand. Çoklu sergileme bölgeleri, LED ekranlar ve merkezi karşılama ile ürün gamı geniş markalar için tasarlandı.',
 'Three-sided open 9-meter-long large stand. Designed for brands with extensive product lines — multiple display zones, LED screens and central reception.',
 '/assets/images/stand-models/UB-01.png', 'active'),

-- ── ADA STAND (6m × 4m) ──────────────────────────
('ad-01-iki-katli-luks', 'AD-01', 'İki Katlı Lüks Ada', 'Two-Story Luxury Island',
 'ada', '6m × 4m', 9800.00, 'EUR',
 JSON_ARRAY('Dört cephe açık', 'İki katlı yapı', 'Üst toplantı katı', 'LED video wall', 'Merkezi bar bankosu', 'Premium mobilya'),
 'Dört cephe açık iki katlı ada stand. Üst katta toplantı alanı, LED video duvarları ve merkezi bar bankosu ile premium markaların amiral standı.',
 'Four-sided open two-story island stand. Flagship booth for premium brands — upper meeting floor, LED video walls and central bar counter.',
 '/assets/images/stand-models/AD-01.png', 'active'),

('ad-02-kavisli-organik', 'AD-02', 'Kavisli Organik Ada', 'Curved Organic Island',
 'ada', '6m × 4m', 8500.00, 'EUR',
 JSON_ARRAY('Dört cephe açık', 'Kavisli organik formlar', 'Asma tavan strüktürü', 'Entegre aydınlatma', 'Merkezi vitrin', 'Beyaz minimal lüks'),
 'Dört cephe açık kavisli organik formlu ada stand. Asma tavan strüktürü ve entegre aydınlatması ile beyaz minimalist lüks tasarım — moda, kozmetik ve lifestyle markaları için.',
 'Four-sided open island with curved organic forms. White minimalist luxury — suspended ceiling structure with integrated lighting. Ideal for fashion, cosmetics and lifestyle brands.',
 '/assets/images/stand-models/AD-02.png', 'active'),

('ad-03-ahsap-altin', 'AD-03', 'Ahşap Altın Detaylı Ada', 'Wood & Gold Island',
 'ada', '6m × 4m', 9200.00, 'EUR',
 JSON_ARRAY('Dört cephe açık', 'Koyu ahşap panel', 'Altın aksanlar', 'Asılı marka bayrakları', 'Lounge oturma alanı', 'Hi-end butik tasarım'),
 'Koyu ahşap panel ve altın aksanlarla premium ada stand. Asılı marka bayrakları, lounge oturma alanı ile prestijli marka algısı yaratan butik tasarım.',
 'Premium island with dark wood panels and gold accents. Suspended brand banners and lounge seating — boutique design for prestigious brand presentations.',
 '/assets/images/stand-models/AD-03.png', 'active'),

('ad-04-truss-tech', 'AD-04', 'Truss Tech Ada', 'Truss Tech Island',
 'ada', '6m × 4m', 10500.00, 'EUR',
 JSON_ARRAY('Dört cephe açık', 'Truss strüktür', 'Tavan LED video wall', 'Mavi-beyaz aydınlatma', 'Fütüristik estetik', 'Teknoloji markaları için'),
 'Truss çerçeve sistemi ve tavan LED video wall ile fütüristik teknoloji ada standı. Mavi-beyaz aydınlatma — yazılım, IoT ve elektronik markaları için ideal.',
 'Futuristic technology island stand with truss frame system and ceiling LED video wall. Blue-white lighting — ideal for software, IoT and electronics brands.',
 '/assets/images/stand-models/AD-04.png', 'active');

SELECT model_no, name_tr, size_category, dimensions, price, currency FROM catalog_items ORDER BY size_category, model_no;
