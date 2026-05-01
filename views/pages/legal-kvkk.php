<?php
$pageTitle       = lang() === 'en'
    ? 'Personal Data Protection Notice | Expo Cyprus'
    : 'KVKK Aydınlatma Metni | Expo Cyprus';
$metaDescription = lang() === 'en'
    ? 'How Expo Cyprus (Unifex Fuarcılık Organizasyon Ltd.) collects, processes and protects personal data under KKTC Law 7/2007 and GDPR.'
    : 'Unifex Fuarcılık Organizasyon Ltd.\'nin (Expo Cyprus) KKTC 7/2007 sayılı Kişisel Verilerin Korunması Yasası ve GDPR kapsamında kişisel verilerinizi nasıl topladığı, işlediği ve koruduğu.';
$bodyClass = 'page-legal';
?>

<section class="page-hero" style="background: linear-gradient(135deg, #1a1a1a 0%, #E30613 100%);">
  <div class="container">
    <div class="page-hero-content">
      <nav class="breadcrumb" aria-label="Breadcrumb">
        <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
        <span aria-hidden="true">›</span>
        <span><?= lang() === 'en' ? 'Personal Data Protection' : 'KVKK Aydınlatma Metni' ?></span>
      </nav>
      <h1 class="page-hero-title"><?= lang() === 'en' ? 'Personal Data Protection' : 'KVKK Aydınlatma Metni' ?></h1>
      <p class="page-hero-subtitle">
        <?= lang() === 'en'
            ? 'How we collect, use, and protect your personal data.'
            : 'Kişisel verilerinizi nasıl topladığımız, kullandığımız ve koruduğumuz.' ?>
      </p>
    </div>
  </div>
</section>

<section class="section">
  <div class="container">
    <div class="legal-content">
      <div class="legal-meta">
        <?= lang() === 'en' ? 'Last updated: 1 April 2026' : 'Son güncelleme: 1 Nisan 2026' ?>
      </div>

      <?php if (lang() === 'en'): ?>
        <h2>Data Controller</h2>
        <p>Unifex Fuarcılık Organizasyon Ltd. (operating under the Expo Cyprus brand), Nicosia, Northern Cyprus. Contact: <a href="mailto:info@expocyprus.com">info@expocyprus.com</a></p>

        <h2>Personal Data Processed</h2>
        <ul>
          <li>First name, last name, email address, phone number</li>
          <li>IP address, cookies, browser/device information</li>
          <li>Form content you submit (quote, contact, registration)</li>
        </ul>

        <h2>Purposes of Processing</h2>
        <ul>
          <li>Responding to your enquiries</li>
          <li>Providing exhibition / congress / stand services</li>
          <li>Issuing invoices and complying with legal obligations</li>
        </ul>

        <h2>Legal Basis</h2>
        <p>Explicit consent, performance of a contract, and legal obligation under KKTC Law 7/2007 on the Protection of Personal Data and the EU General Data Protection Regulation (GDPR).</p>

        <h2>Data Transfer</h2>
        <p>Data may be transferred domestically or internationally only with explicit consent or where strictly necessary for the performance of a contract.</p>

        <h2>Retention Period</h2>
        <p>The legal retention period plus a maximum of 10 years.</p>

        <h2>Your Rights</h2>
        <p>You have the right to access, correct, delete, or object to the processing of your data. Submit requests to <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a>.</p>

        <h2>Security Measures</h2>
        <p>TLS encryption, role-based access control, and audit logging.</p>

        <h2>Effective Date</h2>
        <p>This notice is effective as of 1 April 2026.</p>
      <?php else: ?>
        <h2>Veri Sorumlusu</h2>
        <p>Unifex Fuarcılık Organizasyon Ltd. (Expo Cyprus markası altında faaliyet gösterir), Lefkoşa, KKTC. İletişim: <a href="mailto:info@expocyprus.com">info@expocyprus.com</a></p>

        <h2>İşlenen Kişisel Veriler</h2>
        <ul>
          <li>Ad, soyad, e-posta, telefon numarası</li>
          <li>IP adresi, çerez, tarayıcı/cihaz bilgileri</li>
          <li>Tarafınızdan gönderilen form içeriği (teklif, iletişim, kayıt)</li>
        </ul>

        <h2>İşlenme Amaçları</h2>
        <ul>
          <li>Talep ve sorularınıza yanıt verilmesi</li>
          <li>Fuar / kongre / stand hizmetlerinin sunulması</li>
          <li>Fatura düzenlenmesi ve mevzuata uygunluk</li>
        </ul>

        <h2>Hukuki Sebep</h2>
        <p>Açık rıza, sözleşmenin ifası ve hukuki yükümlülük; KKTC 7/2007 sayılı Kişisel Verilerin Korunması Yasası ile AB Genel Veri Koruma Tüzüğü (GDPR) çerçevesinde.</p>

        <h2>Veri Aktarımı</h2>
        <p>Yurt içi ve/veya yurt dışına yalnızca açık rıza ile veya sözleşmenin ifası için zorunluluk hallerinde aktarılır.</p>

        <h2>Saklama Süresi</h2>
        <p>Yasal saklama süresi + maksimum 10 yıl.</p>

        <h2>Haklarınız</h2>
        <p>Verilerinize ilişkin bilgi alma, düzeltme, silme ve işlenmesine itiraz etme haklarına sahipsiniz. Başvurularınızı <a href="mailto:privacy@expocyprus.com">privacy@expocyprus.com</a> adresine iletebilirsiniz.</p>

        <h2>Güvenlik Önlemleri</h2>
        <p>TLS şifreleme, rol bazlı erişim kontrolü ve denetim logları.</p>

        <h2>Yürürlük</h2>
        <p>Bu metin 1 Nisan 2026 tarihinden itibaren yürürlüktedir.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
.page-hero { position: relative; min-height: 320px; display: flex; align-items: center; color: var(--white); padding: var(--space-4xl) 0 var(--space-3xl); }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.9); margin-top: .75rem; }
.breadcrumb { display: flex; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.75); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.75); }
.breadcrumb a:hover { color: var(--white); }

.legal-content { max-width: 760px; margin: 0 auto; line-height: 1.8; color: var(--text); }
.legal-content h2 { font-size: 1.25rem; font-weight: 700; margin: 2rem 0 .75rem; color: var(--text); }
.legal-content p { margin: 0 0 1rem; }
.legal-content ul { margin: 0 0 1rem; padding-left: 1.5rem; }
.legal-content li { margin-bottom: .5rem; }
.legal-content a { color: var(--red); }
.legal-meta { font-size: .875rem; color: var(--text-muted); padding: 1rem 1.25rem; background: var(--bg-alt); border-left: 3px solid var(--red); border-radius: var(--radius-sm); margin-bottom: 2rem; }
@media (max-width: 768px) { .page-hero-title { font-size: var(--font-size-4xl); } }
</style>
