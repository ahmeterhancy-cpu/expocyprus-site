<?php
$pageTitle = ($member['company_name'] ?? '') . ' #' . $member['id'];
$pretitle = 'Üye Detay';
$st = \App\Models\Member::STATUSES[$member['status']] ?? ['label'=>$member['status'],'color'=>'gray'];
$stages = \App\Models\ProductionOrder::STAGES;
$headerActions = '
    <a href="/admin/members/' . $member['id'] . '/edit" class="btn btn-outline-primary me-2"><i class="ti ti-edit me-1"></i>Düzenle</a>
    <a href="/admin/production-orders/create?member_id=' . $member['id'] . '" class="btn btn-success me-2"><i class="ti ti-plus me-1"></i>Sipariş Oluştur</a>
    <a href="/admin/members" class="btn btn-outline-secondary">← Liste</a>
';
?>

<div class="row">
    <div class="col-lg-4">
        <div class="card mb-3">
            <div class="card-body text-center">
                <span class="avatar avatar-xl bg-<?= e($st['color']) ?>-lt mb-2" style="font-size:1.75rem"><?= mb_strtoupper(mb_substr($member['company_name'], 0, 2)) ?></span>
                <h2 class="mb-1"><?= e($member['company_name']) ?></h2>
                <p class="text-muted mb-2"><?= e($member['contact_name']) ?></p>
                <span class="badge bg-<?= e($st['color']) ?>-lt fs-6"><?= e($st['label']) ?></span>
                <hr>
                <?php if ($member['status'] === 'pending'): ?>
                <form method="POST" action="/admin/members/<?= $member['id'] ?>/approve">
                    <button class="btn btn-success w-100"><i class="ti ti-check me-1"></i>Üyeliği Onayla</button>
                </form>
                <hr>
                <?php endif; ?>
                <dl class="row text-start small mb-0">
                    <dt class="col-5 text-muted">E-posta</dt><dd class="col-7"><a href="mailto:<?= e($member['email']) ?>"><?= e($member['email']) ?></a></dd>
                    <dt class="col-5 text-muted">Telefon</dt><dd class="col-7"><?= e($member['phone'] ?? '—') ?></dd>
                    <?php if (!empty($member['website'])): ?>
                    <dt class="col-5 text-muted">Web</dt><dd class="col-7"><a href="<?= e($member['website']) ?>" target="_blank"><?= e($member['website']) ?></a></dd>
                    <?php endif; ?>
                    <dt class="col-5 text-muted">Şehir / Ülke</dt><dd class="col-7"><?= e($member['city'] ?? '—') ?> / <?= e($member['country']) ?></dd>
                    <dt class="col-5 text-muted">Vergi No</dt><dd class="col-7"><?= e($member['tax_no'] ?? '—') ?></dd>
                    <dt class="col-5 text-muted">Son Giriş</dt><dd class="col-7"><?= !empty($member['last_login_at']) ? timeAgo($member['last_login_at']) : '—' ?></dd>
                    <dt class="col-5 text-muted">Kayıt</dt><dd class="col-7"><?= date('d.m.Y', strtotime($member['created_at'])) ?></dd>
                </dl>
                <?php if (!empty($member['address'])): ?>
                <hr>
                <p class="text-start small mb-0"><?= nl2br(e($member['address'])) ?></p>
                <?php endif; ?>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <form action="/admin/members/<?= $member['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu üyeyi silmek istediğinize emin misiniz?')">
                    <button class="btn btn-outline-danger w-100"><i class="ti ti-trash me-1"></i>Üyeyi Sil</button>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-8">
        <div class="card">
            <div class="card-header"><h3 class="card-title"><?= count($orders) ?> Üretim Siparişi</h3></div>
            <div class="card-body">
                <?php if (empty($orders)): ?>
                <p class="text-muted text-center py-4">Henüz sipariş yok.</p>
                <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-vcenter">
                        <thead><tr><th>Sipariş No</th><th>Başlık</th><th>Etkinlik</th><th>Aşama</th><th>İlerleme</th><th></th></tr></thead>
                        <tbody>
                            <?php foreach ($orders as $o):
                                $sst = $stages[$o['current_stage']] ?? ['label'=>$o['current_stage'],'color'=>'gray'];
                            ?>
                            <tr>
                                <td><code><?= e($o['order_no']) ?></code></td>
                                <td><strong><?= e($o['title']) ?></strong></td>
                                <td class="small text-muted"><?= e($o['event_name'] ?? '—') ?></td>
                                <td><span class="badge bg-<?= e($sst['color']) ?>-lt"><?= e($sst['label']) ?></span></td>
                                <td>
                                    <div class="progress progress-sm" style="width:80px"><div class="progress-bar bg-red" style="width:<?= (int)$o['progress'] ?>%"></div></div>
                                    <small><?= (int)$o['progress'] ?>%</small>
                                </td>
                                <td><a href="/admin/production-orders/<?= $o['id'] ?>" class="btn btn-sm">Aç</a></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
