<?php
$pageTitle = 'PHPagebuilder Kurulum Gerekli';
$pretitle  = 'İlk Kurulum';
?>

<div class="empty">
    <div class="empty-icon">
        <i class="ti ti-tools" style="font-size:3rem"></i>
    </div>
    <p class="empty-title">PHPagebuilder kurulumu tamamlanmamış</p>
    <p class="empty-subtitle text-muted">
        Veritabanı tabloları (<code>pb_pages</code>, <code>pb_page_translations</code>...) henüz oluşturulmamış.
        Tek seferlik kurulum scripti çalıştırılmalı.
    </p>
    <div class="empty-action">
        <a href="/setup-pagebuilder.php?key=expo2026" target="_blank" class="btn btn-primary">
            <i class="ti ti-rocket"></i> Kurulumu Çalıştır
        </a>
    </div>
    <?php if (!empty($error)): ?>
    <div class="mt-4 text-start">
        <details>
            <summary class="text-muted small">Teknik detay</summary>
            <pre class="mt-2 small text-danger" style="white-space:pre-wrap"><?= e($error) ?></pre>
        </details>
    </div>
    <?php endif; ?>
</div>
