-- Maestro DMC referansına uyumlandırma:
-- 1) Çıkar: Malpas, Arkin Palm Beach, Grand Sapphire (Maestro listesinde yok)
-- 2) Ekle: 7 yeni otel — Merit Royal (klasik), Merit Crystal Cove, Kaya Palazzo,
--    Golden Tulip Nicosia, Grand Pasha Kyrenia, Rocks Hotel, Savoy Ottoman Palace
-- Hedef: 19 otel (Maestro DMC ile birebir)

DELETE FROM hotels WHERE slug IN ('malpas-hotel-girne', 'arkin-palm-beach-magusa', 'grand-sapphire-iskele');

-- Mevcut sort_order'ları koruyup yeni 7 otel için 16-22 arası kullan
INSERT INTO hotels (slug, name, region, location, stars, summary_tr, summary_en, description_tr, description_en, features_json, image_main, website_url, phone, rooms, sort_order, status) VALUES

('merit-royal-classic-girne', 'Merit Royal Hotel & Casino', 'Girne', 'Karaoğlanoğlu, Girne, KKTC', 5,
 'Merit Royal''ın klasik tesisi. Premium hizmet, deniz manzarası ve casino.',
 'The classic Merit Royal property. Premium service, sea views and casino.',
 '<p>Merit Royal Hotel, Girne''nin Karaoğlanoğlu mevkiinde, Merit grubunun klasik 5 yıldızlı tesisidir. Geniş plajı, premium SPA olanakları, casino ve gourmet restoranlarıyla orta-büyük ölçek etkinlik gruplarına uygundur.</p>',
 '<p>Merit Royal Hotel is the classic 5-star property of the Merit group in Karaoğlanoğlu, Kyrenia. With its wide beach, premium SPA facilities, casino and gourmet restaurants, it is suitable for medium-to-large event groups.</p>',
 JSON_ARRAY('Plaj','Casino','SPA','Premium Restoran','Kongre Salonu','Animasyon'),
 '/assets/images/hotels/merit-royal-classic-girne.webp',
 'https://www.merithotels.com/en/merit-royal-hotel', '+90 392 650 4040', 286, 16, 'active'),

('merit-crystal-cove-girne', 'Merit Crystal Cove Hotel', 'Girne', 'Alsancak, Girne, KKTC', 5,
 'Alsancak''ta deniz kenarında, geniş bahçeli klasik 5 yıldız. (2026 sonuna kadar yenilemede)',
 'Beachside in Alsancak with extensive gardens, classic 5-star. (Under renovation until end of 2026)',
 '<p>Merit Crystal Cove, Girne''nin Alsancak mevkiinde, deniz kenarındaki klasik tesistir. Geniş bahçesi, özel plajı, casinosu ve etkinlik salonlarıyla bilinir. <strong>Tesis Kasım 2025 - Ağustos 2026 arası kapsamlı yenileme nedeniyle hizmet vermemektedir.</strong></p>',
 '<p>Merit Crystal Cove is a classic property by the sea in Alsancak, Kyrenia. Known for its wide gardens, private beach, casino and event halls. <strong>The facility is closed November 2025 - August 2026 for comprehensive renovation.</strong></p>',
 JSON_ARRAY('Plaj','Geniş Bahçe','Casino','SPA','Kongre Salonu','Yenileme 2026'),
 NULL,
 'https://www.merithotels.com/en/merit-crystal-cove-hotel', '+90 392 650 1212', 304, 17, 'active'),

('kaya-palazzo-girne', 'Kaya Palazzo Resort & Casino', 'Girne', 'Karaoğlanoğlu, Girne, KKTC', 5,
 'Karaoğlanoğlu''nda ön sıra deniz konumunda lüks segment. Kaya grubunun Girne tesisi.',
 'Front-row seafront in Karaoğlanoğlu, luxury segment. Kaya group''s Kyrenia property.',
 '<p>Kaya Palazzo Resort, Girne''nin Karaoğlanoğlu sahil şeridinde lüks konsept sunar. Sosyal alanları geniş, deniz manzaralı odaları, premium casino ve SPA''sı ile etkinlik organizasyonları için elverişlidir.</p>',
 '<p>Kaya Palazzo Resort offers a luxury concept on the Karaoğlanoğlu coastline of Kyrenia. With its spacious social areas, sea-view rooms, premium casino and SPA, it is suitable for event organizations.</p>',
 JSON_ARRAY('Deniz Önü','Casino','SPA','Lüks Konsept','Kongre Salonu','Aile Dostu'),
 '/assets/images/hotels/kaya-palazzo-girne.webp',
 'https://kayahotels.com/en/oteller/kaya-palazzo-resort-casino-girne', '+90 392 650 8888', 250, 18, 'active'),

('golden-tulip-nicosia-lefkosa', 'Golden Tulip Nicosia Hotel & Casino', 'Lefkoşa', 'Lefkoşa Merkez, KKTC', 5,
 'Başkent Lefkoşa''da uluslararası zincir 5 yıldız. İş ve şehir kongreleri için ideal.',
 'International chain 5-star in central Lefkoşa. Ideal for business and city congresses.',
 '<p>Golden Tulip Nicosia, KKTC''nin başkenti Lefkoşa''nın merkezinde uluslararası bir zincirin 5 yıldızlı tesisidir. Modern tasarım, kongre olanakları, casino ve şehir merkezi konumuyla iş seyahati ve kurumsal toplantılar için tercih edilir.</p>',
 '<p>Golden Tulip Nicosia is a 5-star property of an international chain in central Lefkoşa, the capital of TRNC. With its modern design, congress facilities, casino and city-center location, it is preferred for business travel and corporate meetings.</p>',
 JSON_ARRAY('Şehir Merkezi','Casino','Uluslararası Zincir','Kongre Salonu','İş Seyahati','Modern'),
 '/assets/images/hotels/golden-tulip-nicosia-lefkosa.webp',
 'https://www.goldentulip.com/en/hotels/golden-tulip-nicosia', '+90 392 600 3000', 140, 19, 'active'),

('grand-pasha-girne', 'Grand Pasha Kyrenia Hotel & Spa', 'Girne', 'Girne Merkez, KKTC', 5,
 'Girne merkezinde butik lüks. 5 yıldız, casino, SPA ve şehir merkezi konumu.',
 'Boutique luxury in central Kyrenia. 5-star, casino, SPA and city-center location.',
 '<p>Grand Pasha Kyrenia, Girne merkezinde, sahil şeridine yakın butik lüks bir 5 yıldızlı oteldir. Modern tasarımı, casino, SPA ve gourmet restoranlarıyla küçük-orta ölçek etkinlikler için elverişlidir. Pasha Hotels grubunun Girne tesisidir.</p>',
 '<p>Grand Pasha Kyrenia is a boutique luxury 5-star hotel in central Kyrenia, near the coastline. With its modern design, casino, SPA and gourmet restaurants, it is suitable for small-to-medium events. The Kyrenia property of Pasha Hotels group.</p>',
 JSON_ARRAY('Şehir Merkezi','Casino','SPA','Butik Lüks','Modern Tasarım','Konferans'),
 '/assets/images/hotels/grand-pasha-girne.webp',
 'https://pashahotels.com/kyrenia/en/', '+90 392 444 7274', 128, 20, 'active'),

('rocks-hotel-girne', 'Rocks Hotel & Casino', 'Girne', 'Girne Limanı, KKTC', 5,
 'Girne tarihi limanına yakın, butik 5 yıldız. Eğlence ve casino merkezli.',
 'Near Kyrenia historic harbor, boutique 5-star. Entertainment and casino-focused.',
 '<p>Rocks Hotel & Casino, Girne''nin tarihi liman bölgesinde, sahil şeridi üzerindeki butik 5 yıldızlı tesistir. Özel iskelesi, gece kulübü, casino ve zarif restoranlarıyla küçük gruplar ve VIP misafirler için elverişlidir.</p>',
 '<p>Rocks Hotel & Casino is a boutique 5-star property on the coastline in the historic harbor area of Kyrenia. With its private pier, nightclub, casino and elegant restaurants, it is suitable for small groups and VIP guests.</p>',
 JSON_ARRAY('Tarihi Liman','Özel İskele','Casino','Gece Kulübü','Butik Lüks','Premium Restoran'),
 '/assets/images/hotels/rocks-hotel-girne.webp',
 'https://www.rockshotelandcasino.com', '+90 392 815 6666', 128, 21, 'active'),

('savoy-ottoman-girne', 'The Savoy Ottoman Palace', 'Girne', 'Karaoğlanoğlu, Girne, KKTC', 5,
 'Osmanlı temalı görkemli mimari, lüks segment. Mermer detayları ve özel hizmet.',
 'Magnificent Ottoman-themed architecture, luxury segment. Marble details and exclusive service.',
 '<p>The Savoy Ottoman Palace, Girne''nin Karaoğlanoğlu mevkiinde Osmanlı sarayını anımsatan görkemli bir mimariyle inşa edilmiştir. Mermer detayları, lüks SPA, casino ve butik restoranlarıyla seçkin misafirleri ağırlar.</p>',
 '<p>The Savoy Ottoman Palace is built with magnificent architecture reminiscent of an Ottoman palace in Karaoğlanoğlu, Kyrenia. With its marble details, luxury SPA, casino and boutique restaurants, it welcomes select guests.</p>',
 JSON_ARRAY('Osmanlı Mimari','Lüks Mermer','Casino','Premium SPA','Butik Restoran','Sultan Suite'),
 '/assets/images/hotels/savoy-ottoman-girne.webp',
 'https://savoyottomanpalace.com', '+90 392 650 6666', 87, 22, 'active');

-- İsim güncelle: existing "merit-royal-girne" zaten "Merit Royal Premium Hotel" olarak doğru
-- (Maestro'daki "Merit Royal Premium Hotel"e karşılık)

SELECT COUNT(*) as toplam, GROUP_CONCAT(DISTINCT region) as bolgeler FROM hotels WHERE status='active';
