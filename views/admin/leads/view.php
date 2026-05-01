<?php
$pageTitle = ($lead['name'] ?? 'Lead') . ' #' . ($lead['id'] ?? '');
$pretitle  = 'CRM — Lead Detay';
$st = \App\Models\Lead::STATUSES[$lead['status']] ?? ['label' => $lead['status'], 'color' => 'secondary'];
$tp = \App\Models\Lead::TEMPERATURES[$lead['temperature']] ?? ['label' => $lead['temperature'], 'color' => 'gray', 'icon' => '•'];
$srcLabel = \App\Models\Lead::SOURCES[$lead['source']] ?? $lead['source'];
$tags = [];
if (!empty($lead['tags_json'])) $tags = json_decode((string)$lead['tags_json'], true) ?: [];
$headerActions = '
    <a href="/admin/leads/' . $lead['id'] . '/edit" class="btn btn-outline-primary me-2"><i class="ti ti-edit me-1"></i>Düzenle</a>
    <a href="/admin/leads" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Liste</a>
';

$activityIcons = [
    'created'        => ['ti ti-sparkles',  'blue'],
    'note'           => ['ti ti-message-2', 'cyan'],
    'status_change'  => ['ti ti-circle-dot','orange'],
    'file_upload'    => ['ti ti-paperclip', 'green'],
    'file_delete'    => ['ti ti-trash',     'red'],
    'call'           => ['ti ti-phone',     'azure'],
    'email'          => ['ti ti-mail',      'purple'],
    'meeting'        => ['ti ti-users',     'yellow'],
];
$kindLabels = [
    'proposal' => 'Teklif',
    'contract' => 'Sözleşme',
    'brief'    => 'Brif',
    'photo'    => 'Fotoğraf',
    'other'    => 'Diğer',
];
?>

<!-- Lead Header -->
<div class="card mb-3">
    <div class="card-body">
        <div class="row align-items-center">
            <div class="col-auto">
                <span class="avatar avatar-xl bg-<?= e($st['color']) ?>-lt"><?= mb_strtoupper(mb_substr($lead['name'], 0, 2)) ?></span>
            </div>
            <div class="col">
                <h2 class="mb-1"><?= e($lead['name']) ?>
                    <span class="ms-2" title="<?= e($tp['label']) ?>"><?= $tp['icon'] ?></span>
                </h2>
                <div class="text-muted">
                    <?php if (!empty($lead['company'])): ?><strong><?= e($lead['company']) ?></strong> · <?php endif; ?>
                    <?php if (!empty($lead['email'])): ?><a href="mailto:<?= e($lead['email']) ?>"><?= e($lead['email']) ?></a> · <?php endif; ?>
                    <?php if (!empty($lead['phone'])): ?><a href="tel:<?= e($lead['phone']) ?>"><?= e($lead['phone']) ?></a><?php endif; ?>
                </div>
                <?php if (!empty($tags)): ?>
                <div class="mt-2">
                    <?php foreach ($tags as $t): ?>
                    <span class="badge bg-secondary-lt me-1">#<?= e($t) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="col-auto text-end">
                <span class="badge bg-<?= e($st['color']) ?>-lt fs-6"><?= e($st['label']) ?></span>
                <div class="mt-2">
                    <small class="text-muted">Skor: <strong class="text-dark"><?= (int)$lead['score'] ?>/100</strong></small>
                </div>
                <?php if ((int)$lead['has_order'] === 1): ?>
                <div class="mt-1"><span class="badge bg-success">✓ SİPARİŞ VAR</span><?php if (!empty($lead['order_ref'])): ?> <small class="text-muted"><?= e($lead['order_ref']) ?></small><?php endif; ?></div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick status change -->
        <hr>
        <form method="POST" action="/admin/leads/<?= $lead['id'] ?>/status" class="d-flex gap-2 align-items-center flex-wrap">
            <span class="text-muted small me-2">Hızlı Durum Değiştir:</span>
            <?php foreach (\App\Models\Lead::STATUSES as $key => $cfg):
                if ($key === $lead['status']) continue;
            ?>
            <button type="submit" name="status" value="<?= e($key) ?>" class="btn btn-sm btn-<?= e($cfg['color']) ?>-lt">
                → <?= e($cfg['label']) ?>
            </button>
            <?php endforeach; ?>
        </form>
    </div>
</div>

<div class="row">
    <!-- LEFT: Activities + Files -->
    <div class="col-lg-8">
        <!-- Add Note -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-message-plus me-2"></i>Yeni Not / Etkinleşme Kaydet</h3></div>
            <div class="card-body">
                <form method="POST" action="/admin/leads/<?= $lead['id'] ?>/note">
                    <textarea name="body" class="form-control" rows="3" placeholder="Görüşme notunu, e-posta özetini veya gözlemini buraya yaz..." required></textarea>
                    <div class="mt-2 text-end">
                        <button type="submit" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Not Ekle</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Files -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-files me-2"></i>Dosyalar (Teklif / Sözleşme / Brif)</h3></div>
            <div class="card-body">
                <form method="POST" action="/admin/leads/<?= $lead['id'] ?>/upload" enctype="multipart/form-data" class="row g-2 align-items-end mb-3">
                    <div class="col-md-3">
                        <label class="form-label small">Dosya Türü</label>
                        <select name="kind" class="form-select form-select-sm">
                            <?php foreach ($kindLabels as $k => $kl): ?>
                            <option value="<?= e($k) ?>"><?= e($kl) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small">Dosya</label>
                        <input type="file" name="file" class="form-control form-control-sm" required accept=".pdf,.doc,.docx,.xls,.xlsx,.jpg,.jpeg,.png,.webp,.zip">
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small">Not (opsiyonel)</label>
                        <input type="text" name="note" class="form-control form-control-sm" placeholder="Versiyon, açıklama...">
                    </div>
                    <div class="col-md-1">
                        <button type="submit" class="btn btn-sm btn-primary w-100"><i class="ti ti-upload"></i></button>
                    </div>
                </form>

                <?php if (empty($files)): ?>
                <p class="text-muted small mb-0">Henüz dosya yüklenmemiş.</p>
                <?php else: ?>
                <div class="list-group">
                    <?php foreach ($files as $f): ?>
                    <div class="list-group-item d-flex align-items-center gap-3">
                        <i class="ti ti-file-text text-muted" style="font-size:1.5rem"></i>
                        <div class="flex-grow-1">
                            <div>
                                <a href="<?= e($f['path']) ?>" target="_blank"><strong><?= e($f['original']) ?></strong></a>
                                <span class="badge bg-secondary-lt ms-2"><?= e($kindLabels[$f['kind']] ?? $f['kind']) ?></span>
                            </div>
                            <small class="text-muted">
                                <?= number_format((int)$f['size'] / 1024, 0) ?> KB ·
                                <?= date('d.m.Y H:i', strtotime($f['created_at'])) ?>
                                <?php if (!empty($f['note'])): ?> · <em><?= e($f['note']) ?></em><?php endif; ?>
                            </small>
                        </div>
                        <form method="POST" action="/admin/leads/<?= $lead['id'] ?>/file/<?= $f['id'] ?>/delete"
                              onsubmit="return confirm('Sil?')">
                            <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                        </form>
                    </div>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Activity Timeline -->
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title"><i class="ti ti-history me-2"></i>Aktivite Akışı</h3></div>
            <div class="card-body">
                <?php if (empty($activities)): ?>
                <p class="text-muted small mb-0">Henüz aktivite yok.</p>
                <?php else: ?>
                <ul class="timeline list-unstyled" style="margin-left:1rem">
                    <?php foreach ($activities as $a):
                        $icon = $activityIcons[$a['type']] ?? ['ti ti-point', 'gray'];
                        $meta = !empty($a['meta_json']) ? (json_decode((string)$a['meta_json'], true) ?: []) : [];
                    ?>
                    <li class="mb-3" style="position:relative;padding-left:2rem;border-left:2px solid var(--tblr-border-color);">
                        <span class="position-absolute" style="left:-12px;top:0;width:24px;height:24px;background:#fff;border-radius:50%;display:flex;align-items:center;justify-content:center;border:2px solid var(--tblr-<?= e($icon[1]) ?>);color:var(--tblr-<?= e($icon[1]) ?>);">
                            <i class="<?= e($icon[0]) ?>" style="font-size:.75rem"></i>
                        </span>
                        <div>
                            <?php if (!empty($a['title'])): ?>
                            <strong><?= e($a['title']) ?></strong>
                            <?php endif; ?>
                            <small class="text-muted ms-2"><?= e($a['actor_name'] ?? 'Sistem') ?> · <?= timeAgo($a['created_at']) ?></small>
                        </div>
                        <?php if (!empty($a['body'])): ?>
                        <div class="mt-1" style="white-space:pre-wrap"><?= nl2br(e($a['body'])) ?></div>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- RIGHT: Meta info -->
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Meta Bilgi</h3></div>
            <div class="card-body">
                <dl class="row mb-0 small">
                    <dt class="col-5 text-muted">Kaynak</dt>
                    <dd class="col-7"><?= e($srcLabel) ?></dd>
                    <dt class="col-5 text-muted">Sıcaklık</dt>
                    <dd class="col-7"><?= $tp['icon'] ?> <?= e($tp['label']) ?></dd>
                    <dt class="col-5 text-muted">Skor</dt>
                    <dd class="col-7">
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-<?= ($lead['score'] ?? 0) >= 70 ? 'green' : (($lead['score'] ?? 0) >= 40 ? 'yellow' : 'red') ?>" style="width:<?= (int)$lead['score'] ?>%"></div>
                        </div>
                        <small><?= (int)$lead['score'] ?> / 100</small>
                    </dd>
                    <?php if (!empty($lead['expected_value'])): ?>
                    <dt class="col-5 text-muted">Tahmini Değer</dt>
                    <dd class="col-7"><strong><?= e($lead['currency']) ?> <?= number_format((float)$lead['expected_value'], 0, ',', '.') ?></strong></dd>
                    <?php endif; ?>
                    <?php if (!empty($lead['proposal_amount'])): ?>
                    <dt class="col-5 text-muted">Teklif Tutarı</dt>
                    <dd class="col-7"><?= e($lead['currency']) ?> <?= number_format((float)$lead['proposal_amount'], 0, ',', '.') ?></dd>
                    <?php endif; ?>
                    <?php if (!empty($lead['proposal_sent_at'])): ?>
                    <dt class="col-5 text-muted">Teklif Tarihi</dt>
                    <dd class="col-7"><?= date('d.m.Y H:i', strtotime($lead['proposal_sent_at'])) ?></dd>
                    <?php endif; ?>
                    <?php if (!empty($lead['last_contacted_at'])): ?>
                    <dt class="col-5 text-muted">Son İletişim</dt>
                    <dd class="col-7"><?= timeAgo($lead['last_contacted_at']) ?></dd>
                    <?php endif; ?>
                    <dt class="col-5 text-muted">Oluşturulma</dt>
                    <dd class="col-7"><?= date('d.m.Y H:i', strtotime($lead['created_at'])) ?></dd>
                </dl>
            </div>
        </div>

        <?php if (!empty($lead['next_action'])): ?>
        <div class="card mb-3 border-warning">
            <div class="card-header bg-warning-lt"><h3 class="card-title"><i class="ti ti-bell me-2"></i>Sonraki Adım</h3></div>
            <div class="card-body">
                <p class="mb-1"><strong><?= e($lead['next_action']) ?></strong></p>
                <?php if (!empty($lead['next_action_date'])): ?>
                <small class="text-muted"><?= date('d.m.Y H:i', strtotime($lead['next_action_date'])) ?></small>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($lead['event_name'])): ?>
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Etkinlik</h3></div>
            <div class="card-body">
                <strong><?= e($lead['event_name']) ?></strong><br>
                <?php if (!empty($lead['event_location'])): ?><small class="text-muted">📍 <?= e($lead['event_location']) ?></small><br><?php endif; ?>
                <?php if (!empty($lead['event_date'])): ?><small class="text-muted">📅 <?= date('d.m.Y', strtotime($lead['event_date'])) ?></small><?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <?php if (!empty($lead['notes'])): ?>
        <div class="card mb-3">
            <div class="card-header"><h3 class="card-title">Genel Notlar</h3></div>
            <div class="card-body" style="white-space:pre-wrap"><?= nl2br(e($lead['notes'])) ?></div>
        </div>
        <?php endif; ?>

        <?php if (!empty($submission)): ?>
        <div class="card mb-3 border-info">
            <div class="card-header bg-info-lt"><h3 class="card-title">📋 İlişkili Form Başvurusu</h3></div>
            <div class="card-body">
                <a href="/admin/submissions/<?= $submission['id'] ?>" class="btn btn-sm btn-outline-info">Form #<?= $submission['id'] ?> Aç →</a>
                <?php if (!empty($submission['data'])): ?>
                <hr>
                <small class="text-muted">Form içeriği özeti:</small>
                <ul class="list-unstyled small mb-0 mt-1">
                    <?php $shown = 0; foreach ($submission['data'] as $k => $v):
                        if ($shown >= 6 || is_array($v) || $v === '' || $v === null) continue;
                        $shown++;
                    ?>
                    <li><strong><?= e(ucfirst(str_replace('_',' ',$k))) ?>:</strong> <?= e((string)$v) ?></li>
                    <?php endforeach; ?>
                </ul>
                <?php endif; ?>
            </div>
        </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form action="/admin/leads/<?= $lead['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu lead\'i kalıcı olarak silmek istediğinize emin misiniz? Tüm aktiviteler ve dosyalar da silinecek.')">
                    <button class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Lead\'i Sil</button>
                </form>
            </div>
        </div>
    </div>
</div>
