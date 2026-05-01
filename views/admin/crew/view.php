<?php
$pageTitle = ($app['first_name'] ?? '') . ' ' . ($app['last_name'] ?? '') . ' #' . ($app['id'] ?? '');
$pretitle  = 'Crew Başvuru Detayı';
$st  = \App\Models\CrewApplication::STATUSES[$app['status']] ?? ['label' => $app['status'], 'color' => 'secondary'];
$posLabels = \App\Models\CrewApplication::positionLabels($app['positions'] ?? null);
$reg = \App\Models\CrewApplication::REGIONS[$app['regions']] ?? '—';
$workType = \App\Models\CrewApplication::WORK_TYPES[$app['work_type']] ?? '—';
$marital  = \App\Models\CrewApplication::MARITAL_STATUSES[$app['marital_status']] ?? '—';
$education= \App\Models\CrewApplication::EDUCATION_LEVELS[$app['education']] ?? '—';
$transport= \App\Models\CrewApplication::TRANSPORTATION_OPTIONS[$app['transportation']] ?? '—';
$age = !empty($app['birth_date']) ? floor((time() - strtotime($app['birth_date'])) / (365.25 * 86400)) : ($app['age'] ?? null);
$headerActions = '<a href="/admin/crew" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Liste</a>';
?>

<div class="row">
    <div class="col-lg-4">
        <!-- Photos -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Fotoğraflar</h3></div>
            <div class="card-body">
                <?php
                $photos = [
                    'photo_portrait' => 'Portre',
                    'photo_full'     => 'Tam Boy',
                    'photo_profile'  => 'Profil',
                ];
                $hasPhoto = false;
                ?>
                <div class="row g-2">
                    <?php foreach ($photos as $field => $label): if (empty($app[$field])) continue; $hasPhoto = true; ?>
                    <div class="col-12">
                        <a href="<?= e($app[$field]) ?>" target="_blank">
                            <img src="<?= e($app[$field]) ?>" class="img-fluid rounded" alt="<?= e($label) ?>">
                        </a>
                        <small class="text-muted d-block mt-1"><?= e($label) ?></small>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php if (!$hasPhoto): ?>
                <p class="text-muted mb-0">Fotoğraf yüklenmemiş.</p>
                <?php endif; ?>

                <?php if (!empty($app['cv_path'])): ?>
                <hr>
                <a href="<?= e($app['cv_path']) ?>" target="_blank" class="btn btn-outline-primary w-100">
                    <i class="ti ti-file-cv me-1"></i>CV İndir
                </a>
                <?php endif; ?>
            </div>
        </div>

        <!-- Status -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Durum</h3></div>
            <div class="card-body">
                <span class="badge bg-<?= e($st['color']) ?>-lt fs-5 mb-3 d-inline-block"><?= e($st['label']) ?></span>
                <form method="POST" action="/admin/crew/<?= $app['id'] ?>/status">
                    <select name="status" class="form-select form-select-sm mb-2" onchange="this.form.submit()">
                        <?php foreach (\App\Models\CrewApplication::STATUSES as $k => $cfg): ?>
                        <option value="<?= e($k) ?>" <?= $app['status'] === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </form>
            </div>
        </div>

        <!-- Admin Notes -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Admin Notları</h3></div>
            <div class="card-body">
                <form method="POST" action="/admin/crew/<?= $app['id'] ?>/note">
                    <textarea name="admin_notes" class="form-control mb-2" rows="5" placeholder="Sadece adminlerin görebileceği iç notlar..."><?= e($app['admin_notes'] ?? '') ?></textarea>
                    <button class="btn btn-sm btn-primary w-100">Notu Kaydet</button>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="/admin/crew/<?= $app['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu başvuruyu kalıcı olarak silmek istediğinize emin misiniz?')">
                    <button class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Başvuruyu Sil</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><?= e($app['first_name'] . ' ' . $app['last_name']) ?></h3>
                <?php foreach ($posLabels as $pl): ?>
                <span class="badge bg-blue-lt ms-1"><?= e($pl) ?></span>
                <?php endforeach; ?>
            </div>
            <div class="card-body">
                <h4 class="text-muted small mb-2">KİŞİSEL BİLGİLER</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Doğum Tarihi</dt>
                    <dd class="col-md-3"><?= !empty($app['birth_date']) ? e(date('d.m.Y', strtotime($app['birth_date']))) . ($age ? " ($age yaş)" : '') : '—' ?></dd>
                    <dt class="col-md-3 text-muted">Cinsiyet</dt>
                    <dd class="col-md-3"><?= e(ucfirst($app['gender'] ?? '—')) ?></dd>

                    <dt class="col-md-3 text-muted">Uyruk</dt>
                    <dd class="col-md-3"><?= e($app['nationality'] ?? '—') ?></dd>
                    <dt class="col-md-3 text-muted">Kimlik No</dt>
                    <dd class="col-md-3"><?= e($app['id_number'] ?? '—') ?></dd>
                </dl>

                <h4 class="text-muted small mb-2">İLETİŞİM</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Telefon</dt>
                    <dd class="col-md-3"><a href="tel:<?= e($app['phone']) ?>"><?= e($app['phone']) ?></a></dd>
                    <dt class="col-md-3 text-muted">E-posta</dt>
                    <dd class="col-md-3"><a href="mailto:<?= e($app['email']) ?>"><?= e($app['email']) ?></a></dd>

                    <?php if (!empty($app['instagram'])): ?>
                    <dt class="col-md-3 text-muted">Instagram</dt>
                    <dd class="col-md-3">
                        <?php $ig = ltrim($app['instagram'], '@'); ?>
                        <a href="https://instagram.com/<?= e($ig) ?>" target="_blank">@<?= e($ig) ?></a>
                    </dd>
                    <?php endif; ?>
                    <dt class="col-md-3 text-muted">Şehir</dt>
                    <dd class="col-md-3"><?= e($app['city'] ?? '—') ?></dd>

                    <?php if (!empty($app['address'])): ?>
                    <dt class="col-md-3 text-muted">Adres</dt>
                    <dd class="col-md-9"><?= nl2br(e($app['address'])) ?></dd>
                    <?php endif; ?>
                </dl>

                <h4 class="text-muted small mb-2">FİZİKSEL BİLGİLER</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Boy / Kilo</dt>
                    <dd class="col-md-3"><?= e(($app['height_cm'] ?? '') ? $app['height_cm'] . ' cm' : '—') ?> / <?= e(($app['weight_kg'] ?? '') ? $app['weight_kg'] . ' kg' : '—') ?></dd>
                    <dt class="col-md-3 text-muted">Beden</dt>
                    <dd class="col-md-3"><?= e($app['body_size'] ?? '—') ?></dd>

                    <dt class="col-md-3 text-muted">Ayakkabı No</dt>
                    <dd class="col-md-3"><?= e($app['shoe_size'] ?? '—') ?></dd>
                    <dt class="col-md-3 text-muted">Gömlek</dt>
                    <dd class="col-md-3"><?= e($app['shirt_size'] ?? '—') ?></dd>

                    <dt class="col-md-3 text-muted">Saç / Göz</dt>
                    <dd class="col-md-9"><?= e($app['hair_color'] ?? '—') ?> / <?= e($app['eye_color'] ?? '—') ?></dd>
                </dl>

                <h4 class="text-muted small mb-2">EĞİTİM & MEDENİ DURUM</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Medeni Durum</dt>
                    <dd class="col-md-3"><?= e($marital) ?></dd>
                    <dt class="col-md-3 text-muted">Eğitim</dt>
                    <dd class="col-md-3"><?= e($education) ?></dd>
                </dl>

                <h4 class="text-muted small mb-2">POZİSYON & ÇALIŞMA TERCİHLERİ</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Pozisyonlar</dt>
                    <dd class="col-md-9">
                        <?php foreach ($posLabels as $pl): ?><span class="badge bg-blue-lt me-1 mb-1"><?= e($pl) ?></span><?php endforeach; ?>
                        <?php if (!empty($app['position_other'])): ?> <em class="text-muted">(<?= e($app['position_other']) ?>)</em><?php endif; ?>
                    </dd>
                    <dt class="col-md-3 text-muted">Çalışma Şekli</dt>
                    <dd class="col-md-3"><?= e($workType) ?></dd>
                    <dt class="col-md-3 text-muted">Bölge</dt>
                    <dd class="col-md-3"><?= e($reg) ?></dd>

                    <dt class="col-md-3 text-muted">Deneyim</dt>
                    <dd class="col-md-3"><?= (int)($app['experience_years'] ?? 0) ?> yıl <?php if (!empty($app['prior_experience'])): ?><span class="badge bg-success-lt ms-1">Daha önce çalıştı</span><?php endif; ?></dd>
                    <dt class="col-md-3 text-muted">Müsaitlik</dt>
                    <dd class="col-md-3"><?= e($app['availability'] ?? '—') ?></dd>

                    <?php if (!empty($app['languages'])): ?>
                    <dt class="col-md-3 text-muted">Diller</dt>
                    <dd class="col-md-9"><?= e($app['languages']) ?></dd>
                    <?php endif; ?>
                    <?php if (!empty($app['experience_text'])): ?>
                    <dt class="col-md-3 text-muted">Deneyim Açıklaması</dt>
                    <dd class="col-md-9" style="white-space:pre-wrap"><?= nl2br(e($app['experience_text'])) ?></dd>
                    <?php endif; ?>
                </dl>

                <h4 class="text-muted small mb-2">KISITLAR & ULAŞIM</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Seyahat Engeli</dt>
                    <dd class="col-md-3"><?= !empty($app['travel_constraint']) ? '⚠️ Var' : '✓ Yok' ?></dd>
                    <dt class="col-md-3 text-muted">Gece Çalışma</dt>
                    <dd class="col-md-3"><?= !empty($app['night_work']) ? '✓ Evet' : '✗ Hayır' ?></dd>
                    <dt class="col-md-3 text-muted">Ulaşım</dt>
                    <dd class="col-md-9"><?= e($transport) ?></dd>
                </dl>

                <?php if (!empty($app['daily_rate'])): ?>
                <h4 class="text-muted small mb-2">ÜCRET</h4>
                <dl class="row mb-3">
                    <dt class="col-md-3 text-muted">Günlük Ücret</dt>
                    <dd class="col-md-9"><strong><?= e($app['currency']) ?> <?= number_format((float)$app['daily_rate'], 2, ',', '.') ?></strong></dd>
                </dl>
                <?php endif; ?>

                <h4 class="text-muted small mb-2">FOTOĞRAF KULLANIM ONAYI</h4>
                <p><?= !empty($app['photo_usage_consent']) ? '✓ Web sitesi/sosyal medya kullanımına onay verdi' : '✗ Onay vermedi' ?></p>

                <?php if (!empty($app['self_description'])): ?>
                <h4 class="text-muted small mb-2">KENDİSİNİ ANLATIMI</h4>
                <p style="white-space:pre-wrap"><?= nl2br(e($app['self_description'])) ?></p>
                <?php endif; ?>

                <?php if (!empty($app['notes'])): ?>
                <h4 class="text-muted small mb-2">EK NOT</h4>
                <p style="white-space:pre-wrap"><?= nl2br(e($app['notes'])) ?></p>
                <?php endif; ?>

                <hr>
                <small class="text-muted">
                    Başvuru tarihi: <?= date('d.m.Y H:i', strtotime($app['created_at'])) ?>
                    · IP: <?= e($app['ip'] ?? '—') ?>
                    · KVKK: <?= !empty($app['kvkk_accepted']) ? '✓ Onaylandı' : '✗' ?>
                </small>
            </div>
        </div>
    </div>
</div>
