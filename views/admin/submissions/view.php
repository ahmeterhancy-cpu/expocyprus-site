<?php
$pageTitle = 'Başvuru #' . ($submission['id'] ?? '');
$pretitle  = 'Başvurular';
$headerActions = '<a href="/admin/submissions" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri Dön</a>';
$d = $submission['data'] ?? [];

$formTypeLabels = [
    'contact'           => 'İletişim Formu',
    'stand_inquiry'     => 'Stand Talep Formu',
    'quote_request'     => 'Stand Teklifi (Detaylı)',
    'material_request'  => 'Malzeme Talebi',
];
$typeLabel = $formTypeLabels[$submission['form_type']] ?? $submission['form_type'];

$fieldLabels = [
    'contact_name'      => 'Ad Soyad',
    'customer_name'     => 'Ad Soyad',
    'name'              => 'Ad Soyad',
    'company'           => 'Firma',
    'email'             => 'E-posta',
    'phone'             => 'Telefon',
    'message'           => 'Mesaj',
    'notes'             => 'Notlar',
    'fair_name'         => 'Fuar/Etkinlik Adı',
    'fair_date'         => 'Fuar/Etkinlik Tarihi',
    'fair_location'     => 'Etkinlik Yeri',
    'event_name'        => 'Kongre / Fuar / Etkinlik',
    'event_date'        => 'Etkinlik Tarihi',
    'event_location'    => 'Etkinlik Yeri',
    'model_no'          => 'Stand Model No',
    'website'           => 'Web Adresi',
    'stand_type'        => 'Stand Tipi',
    'stand_system'      => 'Stand Sistemi',
    'length_m'          => 'Boy (m)',
    'width_m'           => 'En (m)',
    'height_cm'         => 'Yükseklik (cm)',
    'total_sqm'         => 'Toplam (m²)',
    'structure'         => 'Stand Yapısı',
    'floor_type'        => 'Zemin Tipi',
    'extra_sections'    => 'Ek Bölümler',
    'display_type'      => 'Sergileme Türü',
    'lighting_color'    => 'Aydınlatma Rengi',
    'logo_type'         => 'Logo Tipi',
    'shelf_lighting'    => 'Raf Işıklandırması',
    'shelf_position'    => 'Raf Konumu',
    'budget_min'        => 'Min. Bütçe',
    'budget_max'        => 'Max. Bütçe',
    'currency'          => 'Para Birimi',
    'quantities'        => 'Mobilya / Ekipman Adetleri',
    'led_screen_length' => 'LED Wall Boy (m)',
    'led_screen_width'  => 'LED Wall En (m)',
    'led_screen_pitch'  => 'LED Wall Piksel Aralığı',
    'hostess'           => 'Stand Hostes',
    'hostess_male'      => 'Erkek Hostes (Adet)',
    'hostess_female'    => 'Kadın Hostes (Adet)',
];

$qtyLabels = [
    'q_tables'        => 'Masa (Yuvarlak)',
    'q_tables_2'      => 'Cam Masa',
    'q_reception'     => 'Karşılama Desk',
    'q_chair'         => 'Sandalye (Beyaz)',
    'q_chair_2'       => 'Sandalye (Siyah)',
    'q_vip_chair'     => 'VIP Koltuk',
    'q_sofa_group'    => 'Oturma Grubu',
    'q_bar_stool'     => 'Bar Taburesi',
    'q_brochure_rack' => 'Broşürlük',
    'q_led_tv'        => 'LED TV (Toplam)',
    'q_led_tv_32'     => 'LED TV 32"',
    'q_led_tv_43'     => 'LED TV 43"',
    'q_led_tv_50'     => 'LED TV 50"',
    'q_led_tv_55'     => 'LED TV 55"',
    'q_led_tv_65'     => 'LED TV 65"',
    'q_led_tv_75'     => 'LED TV 75"',
    'q_led_tv_86'     => 'LED TV 86"',
    'q_led_screen'    => 'LED Modüler Ekran (Adet)',
];

function ec_render_value($val, $qtyLabels) {
    if (is_array($val)) {
        if (empty($val)) return '<span class="text-muted">—</span>';
        // İç içe array (ör. quantities)
        $isAssoc = array_keys($val) !== range(0, count($val) - 1);
        if ($isAssoc) {
            $html = '<ul class="list-unstyled mb-0">';
            foreach ($val as $k => $v) {
                $label = $qtyLabels[$k] ?? ucwords(str_replace(['_', '-'], ' ', $k));
                $html .= '<li><strong>' . htmlspecialchars((string)$label) . ':</strong> ' . htmlspecialchars((string)$v) . '</li>';
            }
            $html .= '</ul>';
            return $html;
        }
        return '<span class="badge bg-secondary-lt me-1">' .
               implode('</span><span class="badge bg-secondary-lt me-1">', array_map('htmlspecialchars', array_map('strval', $val))) .
               '</span>';
    }
    if ($val === '' || $val === null) return '<span class="text-muted">—</span>';
    return nl2br(htmlspecialchars((string)$val));
}
?>
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Form Verileri</h3>
                <span class="badge bg-blue-lt ms-2"><?= e($typeLabel) ?></span>
            </div>
            <div class="card-body">
                <?php if (empty($d)): ?>
                    <p class="text-muted">Form verisi bulunamadı.</p>
                <?php else: ?>
                <dl class="row">
                    <?php foreach ($d as $key => $val):
                        $label = $fieldLabels[$key] ?? ucfirst(str_replace('_', ' ', $key));
                    ?>
                    <dt class="col-sm-4 text-muted"><?= e($label) ?></dt>
                    <dd class="col-sm-8"><?= ec_render_value($val, $qtyLabels) ?></dd>
                    <?php endforeach; ?>
                </dl>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header"><h3 class="card-title">Meta Bilgiler</h3></div>
            <div class="card-body">
                <dl class="row mb-0">
                    <dt class="col-5 text-muted">Form Tipi</dt>
                    <dd class="col-7"><span class="badge bg-blue-lt"><?= e($submission['form_type']) ?></span></dd>
                    <dt class="col-5 text-muted">Kaynak Sayfa</dt>
                    <dd class="col-7"><?= e($submission['source_page'] ?? '—') ?></dd>
                    <dt class="col-5 text-muted">IP Adresi</dt>
                    <dd class="col-7"><?= e($submission['ip'] ?? '—') ?></dd>
                    <dt class="col-5 text-muted">Tarih</dt>
                    <dd class="col-7"><?= date('d.m.Y H:i', strtotime($submission['created_at'])) ?></dd>
                    <dt class="col-5 text-muted">Tarayıcı</dt>
                    <dd class="col-7" style="font-size:.75rem;word-break:break-all"><?= e(substr($submission['user_agent'] ?? '', 0, 80)) ?></dd>
                </dl>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body d-grid gap-2">
                <form method="POST" action="/admin/submissions/<?= $submission['id'] ?>/to-lead">
                    <button class="btn btn-success w-100">
                        <i class="ti ti-user-plus me-1"></i>Lead'e Dönüştür
                    </button>
                </form>
                <form action="/admin/submissions/<?= $submission['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu başvuruyu kalıcı olarak silmek istediğinizden emin misiniz?')">
                    <button class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Başvuruyu Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
