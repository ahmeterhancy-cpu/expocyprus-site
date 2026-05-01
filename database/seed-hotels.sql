-- Seed: KKTC Otel Partner Ağı (8 otel)
-- Çalıştırma:
--   mysql.exe -u root expocyprus < seed-hotels.sql
SET NAMES utf8mb4;

INSERT INTO hotels (slug, name, region, location, stars, summary_tr, summary_en, description_tr, description_en, features_json, website_url, phone, rooms, sort_order, status) VALUES
('cratos-premium-hotel-girne', 'Cratos Premium Hotel & Casino', 'Girne', 'Çatalköy, Girne, KKTC', 5,
 '681 oda, kumarhane, 11 restoran, plaj, kapsamlı SPA. Doğu Akdeniz''in en büyük entegre tesislerinden.',
 '681 rooms, casino, 11 restaurants, beach, full SPA. One of the largest integrated resorts in the Eastern Mediterranean.',
 '<p>Cratos Premium Hotel & Casino, Girne''nin doğal güzelliklerle çevrili Çatalköy mevkiinde yer alan, 681 odalı entegre bir tesistir. 11 restoran, kumarhane, kapsamlı SPA, kongre salonları ve özel plajıyla fuar ve etkinlik konuğu için her şey dahil deneyim sunar.</p>',
 '<p>Cratos Premium Hotel & Casino is an integrated resort in Çatalköy, Kyrenia, with 681 rooms. It offers 11 restaurants, casino, full SPA, congress halls and a private beach for fair and event guests.</p>',
 JSON_ARRAY('Plaj','Casino','Kapsamlı SPA','11 Restoran','Kongre Salonları','Aquapark','Outdoor Pool','Indoor Pool'),
 'https://www.cratoshotel.com', '+90 392 650 5000', 681, 1, 'active'),

('acapulco-resort-girne', 'Acapulco Resort Convention SPA', 'Girne', 'Çatalköy, Girne, KKTC', 5,
 '600 oda, deniz altı tüneli, aquapark, kongre merkezi, 5000+ kişilik etkinlik kapasitesi.',
 '600 rooms, underwater tunnel, aquapark, convention center, capacity for 5000+ event guests.',
 '<p>Acapulco Resort, Girne''nin doğal sahil şeridinde 600 odalı entegre bir tesistir. Türkiye''nin ilk deniz altı tüneli, aquapark, geniş kongre merkezi ve özel plajıyla büyük ölçekli etkinliklere ev sahipliği yapar.</p>',
 '<p>Acapulco Resort is a 600-room integrated resort on the natural coastline of Kyrenia. It hosts large-scale events with the first underwater tunnel in Turkey/Cyprus, an aquapark, extensive convention center, and a private beach.</p>',
 JSON_ARRAY('Plaj','Aquapark','Kongre Merkezi','Casino','SPA','Animasyon','Su Altı Tüneli'),
 'https://www.acapulco.com.tr', '+90 392 650 4444', 600, 2, 'active'),

('salamis-bay-conti-magusa', 'Salamis Bay Conti Resort Hotel', 'Mağusa', 'Boğaztepe, Gazimağusa, KKTC', 5,
 'Gazimağusa''nın hemen dışında, geniş plaj alanı ve kongre kapasitesiyle iş etkinlikleri için ideal.',
 'Just outside Famagusta, ideal for business events with extensive beach and convention capacity.',
 '<p>Salamis Bay Conti Resort, Mağusa''nın Boğaztepe mevkiinde, antik Salamis kalıntılarına yakın konumda yer alır. Geniş plaj, çok sayıda restoran, modern kongre salonları ve aile dostu olanaklarıyla ön planda.</p>',
 '<p>Salamis Bay Conti Resort is located in Boğaztepe, Famagusta, near the ancient Salamis ruins. It stands out with its wide beach, multiple restaurants, modern convention halls and family-friendly facilities.</p>',
 JSON_ARRAY('Plaj','Casino','SPA','Tenis Kortları','Kongre Salonu','Animasyon'),
 'https://www.salamisbayconti.com', '+90 392 378 8201', 432, 3, 'active'),

('merit-royal-girne', 'Merit Royal Premium Hotel', 'Girne', 'Karaoğlanoğlu, Girne, KKTC', 5,
 'Lüks segmentte konumlanmış, premium hizmet ve özel plaj sunan 5 yıldızlı tesis.',
 '5-star property positioned in luxury segment, offering premium service and private beach.',
 '<p>Merit Royal Premium, Girne''nin Karaoğlanoğlu mevkiinde lüks konsept sunan 5 yıldızlı bir oteldir. Şık tasarımı, kişiye özel hizmet anlayışı ve premium SPA olanaklarıyla seçkin misafirleri ağırlar.</p>',
 '<p>Merit Royal Premium is a luxury 5-star hotel in Karaoğlanoğlu, Kyrenia. It welcomes select guests with elegant design, personalized service and premium SPA facilities.</p>',
 JSON_ARRAY('Plaj','Premium SPA','Casino','Lüks Restoranlar','Kongre Salonu','Concierge'),
 'https://www.merithotels.com', '+90 392 650 4040', 200, 4, 'active'),

('kaya-artemis-bafra', 'Kaya Artemis Resort & Casino', 'Bafra', 'Bafra Turizm Bölgesi, İskele, KKTC', 5,
 'Antik Yunan teması, 1100 oda, deluxe casino, geniş plaj — büyük gruplar için uygundur.',
 'Ancient Greek theme, 1100 rooms, deluxe casino, extensive beach — suitable for large groups.',
 '<p>Kaya Artemis, Bafra Turizm Bölgesi''nde 1100 odalı dev bir tesistir. Antik Yunan temalı mimarisi, geniş plajı, deluxe casinosu ve çoklu havuzlarıyla büyük etkinlik gruplarını ağırlar.</p>',
 '<p>Kaya Artemis is a giant 1100-room property in the Bafra Tourism Region. Its ancient Greek themed architecture, wide beach, deluxe casino and multiple pools accommodate large event groups.</p>',
 JSON_ARRAY('Plaj','Deluxe Casino','Çoklu Havuzlar','Antik Tema','Animasyon','Kongre Salonu','SPA'),
 'https://www.kayatourism.com.tr', '+90 392 680 1010', 1100, 5, 'active'),

('concorde-luxury-bafra', 'Concorde Luxury Resort', 'Bafra', 'Bafra Turizm Bölgesi, İskele, KKTC', 5,
 'Yeni nesil lüks tesis. 700 oda, 24 saat all-inclusive, premium plaj ve casino.',
 'Next-gen luxury property. 700 rooms, 24-hour all-inclusive, premium beach and casino.',
 '<p>Concorde Luxury Resort, Bafra Turizm Bölgesi''nin en yeni 5 yıldızlı tesislerinden biridir. 700 odası, 24 saat all-inclusive konsepti, premium plajı ve casinosuyla modern lüks deneyimi sunar.</p>',
 '<p>Concorde Luxury Resort is one of the newest 5-star properties in the Bafra Tourism Region. With 700 rooms, 24-hour all-inclusive concept, premium beach and casino, it offers a modern luxury experience.</p>',
 JSON_ARRAY('Plaj','Casino','24h All-Inclusive','SPA','Kongre Salonu','Çoklu Restoran'),
 'https://www.concordeluxury.com', '+90 392 680 5050', 700, 6, 'active'),

('elexus-girne', 'Elexus Hotel Resort & SPA', 'Girne', 'Karaoğlanoğlu, Girne, KKTC', 5,
 'Modern mimarisi ve geniş etkinlik altyapısıyla iş ve eğlenceyi birleştiren 5 yıldız.',
 '5-star combining business and leisure with modern architecture and extensive event infrastructure.',
 '<p>Elexus Hotel, Girne''nin Karaoğlanoğlu sahilinde, modern mimarisi, geniş bahçeleri ve yüksek kapasiteli kongre salonlarıyla bilinir. Plaj, çoklu havuzlar ve premium hizmet sunar.</p>',
 '<p>Elexus Hotel is known for its modern architecture, expansive gardens and high-capacity congress halls on the Karaoğlanoğlu coast of Kyrenia. Offers beach, multiple pools and premium service.</p>',
 JSON_ARRAY('Plaj','Casino','Çoklu Havuz','Kongre Salonu','SPA','Modern Mimari'),
 'https://www.elexushotel.com', '+90 392 650 2000', 600, 7, 'active'),

('lords-palace-girne', 'Lords Palace Hotel SPA Casino', 'Girne', 'Girne Merkez, KKTC', 5,
 'Girne merkezinde, deniz manzaralı butik lüks. Konferans ve küçük gruplar için ideal.',
 'Boutique luxury with sea view in central Kyrenia. Ideal for conferences and small groups.',
 '<p>Lords Palace Hotel, Girne merkezinde, eski limana yakın konumda yer alır. Şehir hayatına hakim, deniz manzaralı butik lüks bir tesistir. Casino, SPA ve şık restoranlarıyla küçük-orta ölçek etkinlikler için ideal.</p>',
 '<p>Lords Palace Hotel is in central Kyrenia, near the old harbor. A boutique luxury property with sea views, dominating city life. Ideal for small-to-medium events with casino, SPA and elegant restaurants.</p>',
 JSON_ARRAY('Deniz Manzarası','Casino','SPA','Şehir Merkezi','Konferans Salonu','Restoran'),
 'https://www.lordspalacehotel.com', '+90 392 650 9000', 250, 8, 'active');
