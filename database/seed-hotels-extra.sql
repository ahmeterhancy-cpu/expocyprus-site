-- 7 ek KKTC oteli (toplam 15'e tamamlamak için)

INSERT INTO hotels (slug, name, region, location, stars, summary_tr, summary_en, description_tr, description_en, features_json, website_url, phone, rooms, sort_order, status) VALUES

('limak-cyprus-deluxe-bafra', 'Limak Cyprus Deluxe Hotel', 'Bafra', 'Bafra Turizm Bölgesi, İskele, KKTC', 5,
 'Bafra''nın en yeni jenerasyon 5 yıldızlı tesislerinden. 700+ oda, geniş plaj, premium SPA ve casino.',
 'One of the newest 5-star properties in Bafra. 700+ rooms, extensive beach, premium SPA and casino.',
 '<p>Limak Cyprus Deluxe, Bafra Turizm Bölgesi''nde Limak Hotels grubunun amiral gemisi olarak hizmet verir. 700+ odalı, all-inclusive konseptli tesisi; geniş özel plajı, çok sayıda yüzme havuzu, lüks restoranları ve modern kongre olanaklarıyla büyük ölçek etkinlikleri ağırlamaya elverişlidir.</p>',
 '<p>Limak Cyprus Deluxe serves as the flagship of the Limak Hotels group in the Bafra Tourism Region. With 700+ rooms and an all-inclusive concept, the property hosts large-scale events with its private beach, multiple pools, luxury restaurants and modern convention facilities.</p>',
 JSON_ARRAY('Plaj','All-Inclusive','Casino','Premium SPA','Çoklu Havuz','Kongre Salonu','Animasyon','Lüks Restoran'),
 'https://www.limakhotels.com', '+90 392 680 4444', 720, 9, 'active'),

('noahs-ark-bafra', 'Noah''s Ark Deluxe Hotel & Casino', 'Bafra', 'Bafra Turizm Bölgesi, İskele, KKTC', 5,
 'Nuh''un Gemisi temalı ikonik tasarım. 750 oda, hayvanat bahçesi, eğlence parkı, geniş aktivite alanı.',
 'Iconic Noah''s Ark themed design. 750 rooms, zoo, amusement park, extensive activity area.',
 '<p>Noah''s Ark Deluxe Hotel, Bafra''da gemi formunda inşa edilmiş eşsiz mimarisiyle dikkat çeker. 750 odalı tesis; mini hayvanat bahçesi, eğlence parkı, casino ve geniş plajıyla aile ve grup etkinlikleri için ideal bir seçimdir.</p>',
 '<p>Noah''s Ark Deluxe Hotel stands out with its unique architecture built in the form of a ship in Bafra. The 750-room property is ideal for family and group events with its mini zoo, amusement park, casino and extensive beach.</p>',
 JSON_ARRAY('Plaj','Tematik Mimari','Casino','Hayvanat Bahçesi','Eğlence Parkı','SPA','Animasyon','Çoklu Havuz'),
 'https://www.noahsarkhotel.com', '+90 392 444 5566', 750, 10, 'active'),

('malpas-hotel-girne', 'Malpas Hotel & Casino', 'Girne', 'Çatalköy, Girne, KKTC', 5,
 'Modern mimarisi ve sahip olduğu doğal göl ile özgün konsept. Premium casino ve etkinlik salonları.',
 'Unique concept with modern architecture and a natural lake on-site. Premium casino and event halls.',
 '<p>Malpas Hotel & Casino, Girne''nin Çatalköy mevkiinde modern mimari ve özgün doğal göl konseptiyle öne çıkar. Geniş kongre salonları, premium casino, çoklu restoranlar ve aktivite alanlarıyla iş seyahati ve etkinlik organizasyonları için tercih edilir.</p>',
 '<p>Malpas Hotel & Casino stands out with its modern architecture and unique natural lake concept in Çatalköy, Kyrenia. With extensive convention halls, premium casino, multiple restaurants and activity areas, it is preferred for business travel and event organization.</p>',
 JSON_ARRAY('Doğal Göl','Casino','Modern Mimari','Kongre Salonu','SPA','Çoklu Havuz','Premium Restoran'),
 'https://www.malpashotel.com', '+90 392 444 8800', 380, 11, 'active'),

('merit-park-girne', 'Merit Park Hotel & Casino', 'Girne', 'Alsancak, Girne, KKTC', 5,
 'Geniş bahçeleriyle aile dostu lüks. 200+ oda, premium plaj, casino ve etkinlik altyapısı.',
 'Family-friendly luxury with wide gardens. 200+ rooms, premium beach, casino and event infrastructure.',
 '<p>Merit Park Hotel, Girne''nin Alsancak mevkiinde Merit grubunun aile odaklı tesisidir. Geniş bahçesi, özel plajı, casinosu ve modern kongre olanaklarıyla orta ölçek etkinlikler ve aile katılımcı misafirler için uygun bir seçimdir.</p>',
 '<p>Merit Park Hotel is the family-oriented property of the Merit group in Alsancak, Kyrenia. With its wide gardens, private beach, casino and modern convention facilities, it is a suitable choice for medium-scale events and family-attendee guests.</p>',
 JSON_ARRAY('Plaj','Geniş Bahçe','Casino','Aile Dostu','Kongre Salonu','SPA','Tenis Kortu'),
 'https://www.merithotels.com', '+90 392 650 4040', 230, 12, 'active'),

('arkin-palm-beach-magusa', 'The Arkin Palm Beach Hotel', 'Mağusa', 'Palmiyeler Sahili, Gazimağusa, KKTC', 5,
 'Mağusa''nın ünlü Palmiyeler sahilinde, deniz manzaralı butik 5 yıldız.',
 'Boutique 5-star with sea view on the famous Palm Beach of Famagusta.',
 '<p>The Arkin Palm Beach Hotel, Mağusa''nın ünlü Palmiyeler Plajı''nda, hemen kumsalın yanında konumlanmış butik bir lüks oteldir. Tarihi Mağusa surları ile modern konforu birleştiren tesis; deniz manzaralı odaları, açık-kapalı havuzları ve kaliteli restoranlarıyla öne çıkar.</p>',
 '<p>The Arkin Palm Beach Hotel is a boutique luxury property right on the famous Palm Beach of Famagusta, next to the sand. Combining the historical Famagusta walls with modern comfort, the property stands out with its sea-view rooms, indoor-outdoor pools and quality restaurants.</p>',
 JSON_ARRAY('Palmiyeler Plajı','Deniz Manzarası','Tarihi Çevre','SPA','Kapalı/Açık Havuz','Restoran'),
 'https://www.arkinpalmbeach.com', '+90 392 366 2000', 108, 13, 'active'),

('grand-sapphire-iskele', 'Grand Sapphire Resort & Casino', 'İskele', 'Long Beach, İskele, KKTC', 5,
 'İskele Long Beach''te yeni nesil dev tesis. Geniş plaj, modern casino, çoklu havuz ve etkinlik kapasitesi.',
 'Next-gen mega-resort on Long Beach, İskele. Extensive beach, modern casino, multiple pools and event capacity.',
 '<p>Grand Sapphire Resort, İskele bölgesinin gelişen turizm şeridi Long Beach''te yer alan büyük ölçekli yeni nesil bir tesistir. Modern mimarisi, geniş plajı, casino, çoklu havuzlar ve kapsamlı etkinlik altyapısıyla büyük gruplar için elverişlidir.</p>',
 '<p>Grand Sapphire Resort is a large-scale next-generation property on Long Beach, the developing tourism strip of the İskele region. Suitable for large groups with its modern architecture, extensive beach, casino, multiple pools and comprehensive event infrastructure.</p>',
 JSON_ARRAY('Long Beach','Casino','Modern Mimari','Çoklu Havuz','Kongre Salonu','SPA','Aile Dostu'),
 'https://www.grandsapphirehotel.com', '+90 533 850 5050', 850, 14, 'active'),

('merit-lefkosa', 'Merit Lefkoşa Hotel', 'Lefkoşa', 'Dereboyu, Lefkoşa, KKTC', 5,
 'Başkent Lefkoşa''nın merkezinde, iş seyahati ve şehir kongreleri için ideal 5 yıldız.',
 'In central Lefkoşa, the capital — ideal 5-star for business travel and city congresses.',
 '<p>Merit Lefkoşa Hotel, KKTC''nin başkenti Lefkoşa''nın iş ve sosyal hayatın merkezi Dereboyu''nda yer alır. Şehir merkezi konumu, casino, modern kongre salonları ve premium restoranlarıyla iş seyahati, kurumsal toplantı ve şehir içi kongreler için önde gelen tercihtir.</p>',
 '<p>Merit Lefkoşa Hotel is located in Dereboyu, the center of business and social life in Lefkoşa, the capital of TRNC. With its city-center location, casino, modern congress halls and premium restaurants, it is a leading choice for business travel, corporate meetings and city congresses.</p>',
 JSON_ARRAY('Şehir Merkezi','Casino','Kongre Salonu','İş Seyahati','Premium Restoran','SPA'),
 'https://www.merithotels.com', '+90 392 444 0850', 320, 15, 'active');
