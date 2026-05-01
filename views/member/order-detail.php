<?php
$pageTitle = $order['order_no'] . ' | Sipariş Takibi';
$stages = \App\Models\ProductionOrder::STAGES;
$st = $stages[$order['current_stage']] ?? ['label' => $order['current_stage'], 'color' => 'gray', 'icon' => 'ti-circle'];

// Build stage timeline status: completed, current, pending
$stageOrder = ['order_received','design','design_review','design_approved','production','qc','shipping_ready','on_site','completed'];
$currentIdx = array_search($order['current_stage'], $stageOrder, true);
?>

<div class="mp-od-head">
    <a href="/uye/siparisler" class="mp-back-link">← Tüm siparişler</a>
    <div class="mp-od-title">
        <div>
            <span class="mp-order-no"><?= e($order['order_no']) ?></span>
            <h1><?= e($order['title']) ?></h1>
            <?php if (!empty($order['event_name'])): ?>
            <p>📅 <?= e($order['event_name']) ?>
                <?php if (!empty($order['event_date'])): ?> · <?= date('d.m.Y', strtotime($order['event_date'])) ?><?php endif; ?>
                <?php if (!empty($order['event_location'])): ?> · 📍 <?= e($order['event_location']) ?><?php endif; ?>
            </p>
            <?php endif; ?>
        </div>
        <span class="mp-stage-badge mp-stage-<?= e($st['color']) ?>" style="font-size:.85rem;padding:.5rem 1rem"><?= e($st['label']) ?></span>
    </div>
</div>

<!-- Stage Timeline -->
<div class="mp-card">
    <h2>Üretim Süreci</h2>
    <div class="mp-progress mp-progress-lg">
        <div class="mp-progress-bar" style="width: <?= (int)$order['progress'] ?>%"></div>
    </div>
    <p class="mp-progress-percent"><?= (int)$order['progress'] ?>% tamamlandı</p>

    <ol class="mp-timeline">
        <?php foreach ($stageOrder as $idx => $stageKey):
            $sCfg = $stages[$stageKey];
            if ($order['current_stage'] === 'cancelled') {
                $status = 'cancelled';
            } elseif ($idx < $currentIdx) {
                $status = 'completed';
            } elseif ($idx === $currentIdx) {
                $status = 'current';
            } else {
                $status = 'pending';
            }
            // Find log entry for this stage
            $logged = null;
            foreach ($stagesLog as $l) if ($l['stage'] === $stageKey) $logged = $l;
        ?>
        <li class="mp-timeline-item mp-timeline-<?= e($status) ?>">
            <div class="mp-timeline-dot">
                <?php if ($status === 'completed'): ?>✓<?php elseif ($status === 'current'): ?>•<?php else: ?><?= $idx + 1 ?><?php endif; ?>
            </div>
            <div class="mp-timeline-body">
                <h4><?= e($sCfg['label']) ?></h4>
                <?php if ($logged): ?>
                <small><?= date('d.m.Y H:i', strtotime($logged['created_at'])) ?> · <?= e($logged['actor_name']) ?></small>
                <?php if (!empty($logged['note'])): ?>
                <p class="mp-timeline-note"><?= nl2br(e($logged['note'])) ?></p>
                <?php endif; ?>
                <?php elseif ($status === 'current'): ?>
                <small>Şu anda bu aşamada</small>
                <?php else: ?>
                <small style="color:#86868b">Henüz başlamadı</small>
                <?php endif; ?>
            </div>
        </li>
        <?php endforeach; ?>
    </ol>
</div>

<div class="mp-od-grid">
    <!-- Order Info -->
    <div class="mp-card">
        <h2>Sipariş Detayları</h2>
        <dl class="mp-dl">
            <?php if (!empty($order['stand_type'])): ?>
            <dt>Stand Tipi</dt><dd><?= e($order['stand_type']) ?></dd>
            <?php endif; ?>
            <?php if (!empty($order['stand_system'])): ?>
            <dt>Stand Sistemi</dt><dd><?= e($order['stand_system']) ?></dd>
            <?php endif; ?>
            <?php if (!empty($order['dimensions'])): ?>
            <dt>Boyut</dt><dd><?= e($order['dimensions']) ?></dd>
            <?php endif; ?>
            <?php if (!empty($order['total_sqm'])): ?>
            <dt>Toplam (m²)</dt><dd><?= e($order['total_sqm']) ?></dd>
            <?php endif; ?>
            <?php if (!empty($order['expected_delivery'])): ?>
            <dt>Tahmini Teslim</dt><dd><?= date('d.m.Y', strtotime($order['expected_delivery'])) ?></dd>
            <?php endif; ?>
            <?php if (!empty($order['total_amount'])): ?>
            <dt>Toplam Tutar</dt><dd><strong><?= e($order['currency']) ?> <?= number_format((float)$order['total_amount'], 2, ',', '.') ?></strong></dd>
            <dt>Ödenen</dt><dd><?= e($order['currency']) ?> <?= number_format((float)$order['paid_amount'], 2, ',', '.') ?></dd>
            <?php endif; ?>
        </dl>
        <?php if (!empty($order['description'])): ?>
        <hr>
        <p style="white-space:pre-wrap"><?= nl2br(e($order['description'])) ?></p>
        <?php endif; ?>
    </div>

    <!-- Files -->
    <div class="mp-card">
        <h2>Dosyalar</h2>
        <?php if (empty($files)): ?>
        <p class="text-muted">Henüz dosya paylaşılmadı.</p>
        <?php else: ?>
        <div class="mp-files-list">
            <?php foreach ($files as $f): ?>
            <a href="<?= e($f['path']) ?>" target="_blank" class="mp-file-item">
                <span class="mp-file-icon">📄</span>
                <span class="mp-file-info">
                    <strong><?= e($f['original']) ?></strong>
                    <small><?= e($f['kind']) ?> · <?= number_format((int)$f['size']/1024, 0) ?> KB · <?= date('d.m.Y', strtotime($f['created_at'])) ?></small>
                    <?php if (!empty($f['note'])): ?>
                    <em><?= e($f['note']) ?></em>
                    <?php endif; ?>
                </span>
            </a>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Messages -->
<div class="mp-card">
    <h2>Mesajlaşma</h2>
    <p class="text-muted small">Üretim ekibimizle bu siparişle ilgili mesajlaşabilirsiniz.</p>

    <div class="mp-messages">
        <?php if (empty($messages)): ?>
        <p class="text-muted">Henüz mesaj yok. İlk mesajınızı gönderin.</p>
        <?php else: foreach ($messages as $m): ?>
        <div class="mp-msg mp-msg-<?= e($m['from_role']) ?>">
            <div class="mp-msg-head">
                <strong><?= e($m['from_name'] ?? ($m['from_role'] === 'admin' ? 'Expo Cyprus' : 'Siz')) ?></strong>
                <small><?= date('d.m.Y H:i', strtotime($m['created_at'])) ?></small>
            </div>
            <div class="mp-msg-body" style="white-space:pre-wrap"><?= nl2br(e($m['body'])) ?></div>
        </div>
        <?php endforeach; endif; ?>
    </div>

    <form method="POST" action="/uye/siparis/<?= $order['id'] ?>/mesaj" class="mp-msg-form">
        <?= csrf_field() ?>
        <textarea name="body" rows="3" placeholder="Mesajınızı yazın..." required></textarea>
        <button type="submit" class="mp-btn">Gönder</button>
    </form>
</div>

<style>
.mp-od-head { margin-bottom: 2rem; }
.mp-back-link { color: #6e6e73; text-decoration: none; font-size: .875rem; }
.mp-back-link:hover { color: #E30613; }
.mp-od-title { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-top: 1rem; }
.mp-od-title h1 { font-size: 1.75rem; font-weight: 700; margin: .25rem 0; color: #1d1d1f; }
.mp-od-title p { color: #6e6e73; margin: 0; }

.mp-card {
    background: #fff; border-radius: 16px; padding: 2rem;
    border: 1px solid #e5e5e7; margin-bottom: 1.5rem;
}
.mp-card h2 { font-size: 1.25rem; font-weight: 700; margin: 0 0 1.25rem; color: #1d1d1f; }
.mp-card hr { border: 0; border-top: 1px solid #e5e5e7; margin: 1.25rem 0; }

.mp-progress.mp-progress-lg { height: 12px; }
.mp-progress { height: 8px; background: #f5f5f7; border-radius: 100px; overflow: hidden; }
.mp-progress-bar { height: 100%; background: linear-gradient(90deg, #E30613, #ff6b35); transition: width .35s; }
.mp-progress-percent { font-size: .8125rem; color: #6e6e73; margin: .5rem 0 1.5rem; }

.mp-timeline { list-style: none; padding: 0; margin: 0; }
.mp-timeline-item {
    display: flex; gap: 1rem; padding: 1rem 0;
    position: relative; border-left: 2px solid #e5e5e7;
    margin-left: 16px; padding-left: 1.5rem;
}
.mp-timeline-item:last-child { border-left-color: transparent; }
.mp-timeline-dot {
    position: absolute; left: -16px; top: 1rem;
    width: 32px; height: 32px; border-radius: 50%;
    background: #f5f5f7; color: #86868b;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: .8125rem;
    border: 2px solid #fff; box-shadow: 0 0 0 2px #e5e5e7;
}
.mp-timeline-completed .mp-timeline-dot { background: #10b981; color: #fff; box-shadow: 0 0 0 2px #10b981; }
.mp-timeline-completed { border-left-color: #10b981; }
.mp-timeline-current .mp-timeline-dot {
    background: #E30613; color: #fff; box-shadow: 0 0 0 2px #E30613;
    animation: pulse 2s infinite;
}
@keyframes pulse { 0%, 100% { transform: scale(1); } 50% { transform: scale(1.1); } }
.mp-timeline-cancelled .mp-timeline-dot { background: #ef4444; color: #fff; }
.mp-timeline-body h4 { font-size: 1rem; font-weight: 600; margin: 0 0 .25rem; color: #1d1d1f; }
.mp-timeline-body small { font-size: .75rem; color: #6e6e73; }
.mp-timeline-note {
    margin-top: .5rem; padding: .75rem; background: #f5f5f7;
    border-radius: 8px; font-size: .875rem; color: #1d1d1f;
}

.mp-od-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem; }
@media (max-width: 768px) { .mp-od-grid { grid-template-columns: 1fr; } }
.mp-dl { margin: 0; }
.mp-dl dt { font-size: .75rem; color: #86868b; text-transform: uppercase; letter-spacing: .05em; margin-top: .75rem; }
.mp-dl dd { margin: 0; color: #1d1d1f; font-weight: 500; }

.mp-files-list { display: flex; flex-direction: column; gap: .5rem; }
.mp-file-item {
    display: flex; gap: .75rem; padding: .75rem 1rem;
    background: #f5f5f7; border-radius: 12px;
    text-decoration: none; color: inherit; transition: all .15s;
}
.mp-file-item:hover { background: #fff; border: 1px solid #E30613; }
.mp-file-icon { font-size: 1.5rem; }
.mp-file-info { display: flex; flex-direction: column; gap: .125rem; flex: 1; min-width: 0; }
.mp-file-info strong { color: #1d1d1f; font-size: .9375rem; word-break: break-all; }
.mp-file-info small { color: #6e6e73; font-size: .75rem; }
.mp-file-info em { color: #E30613; font-size: .75rem; font-style: normal; }

.mp-messages {
    display: flex; flex-direction: column; gap: 1rem;
    max-height: 400px; overflow-y: auto; padding: 1rem;
    background: #f5f5f7; border-radius: 12px; margin-bottom: 1rem;
}
.mp-msg {
    background: #fff; padding: 1rem; border-radius: 12px;
    max-width: 80%;
}
.mp-msg-admin { align-self: flex-start; border-bottom-left-radius: 4px; }
.mp-msg-member { align-self: flex-end; background: #E30613; color: #fff; border-bottom-right-radius: 4px; }
.mp-msg-member .mp-msg-head small { color: rgba(255,255,255,.7); }
.mp-msg-head { display: flex; justify-content: space-between; gap: 1rem; margin-bottom: .25rem; font-size: .75rem; }
.mp-msg-head small { color: #6e6e73; }

.mp-msg-form { display: flex; gap: .5rem; align-items: flex-end; }
.mp-msg-form textarea {
    flex: 1; padding: .75rem 1rem;
    border: 1px solid #d2d2d7; border-radius: 12px;
    font-family: inherit; font-size: .9375rem;
    resize: vertical;
}
.mp-btn {
    padding: .75rem 1.5rem; border-radius: 12px;
    background: #E30613; color: #fff; border: 0;
    font-weight: 600; cursor: pointer;
}
.mp-btn:hover { background: #c00510; }

.text-muted { color: #86868b; }
.small { font-size: .75rem; }

.mp-stage-badge { font-size: .75rem; font-weight: 600; padding: .35rem .75rem; border-radius: 100px; background: #f5f5f7; color: #1d1d1f; white-space: nowrap; }
.mp-stage-blue { background: #DBEAFE; color: #1E40AF; } .mp-stage-cyan { background: #CFFAFE; color: #155E75; }
.mp-stage-orange { background: #FED7AA; color: #9A3412; } .mp-stage-teal { background: #CCFBF1; color: #115E59; }
.mp-stage-yellow { background: #FEF3C7; color: #92400E; } .mp-stage-lime { background: #ECFCCB; color: #3F6212; }
.mp-stage-indigo { background: #E0E7FF; color: #3730A3; } .mp-stage-purple { background: #F3E8FF; color: #6B21A8; }
.mp-stage-green { background: #D1FAE5; color: #065F46; } .mp-stage-red { background: #FEE2E2; color: #991B1B; }
.mp-order-no { font-family: monospace; font-size: .75rem; color: #86868b; letter-spacing: .05em; }
</style>
