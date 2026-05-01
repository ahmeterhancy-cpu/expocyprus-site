<?php
$pageTitle = 'Siparişlerim | Expo Cyprus';
$stages = \App\Models\ProductionOrder::STAGES;
?>

<div class="mp-page-head">
    <h1>Siparişlerim</h1>
    <p>Tüm üretim siparişlerinizi ve aşamalarını buradan takip edebilirsiniz.</p>
</div>

<?php if (empty($orders)): ?>
<div class="mp-empty">
    <p>Henüz sipariş bulunmuyor.</p>
    <p class="text-muted">Yeni bir teklif almak için <a href="/teklif-al">Teklif İste</a> sayfasını ziyaret edin.</p>
</div>
<?php else: ?>
<div class="mp-orders-list">
    <?php foreach ($orders as $o):
        $st = $stages[$o['current_stage']] ?? ['label' => $o['current_stage'], 'color' => 'gray'];
    ?>
    <a href="/uye/siparis/<?= $o['id'] ?>" class="mp-order-row">
        <div class="mp-order-row-head">
            <div>
                <span class="mp-order-no"><?= e($o['order_no']) ?></span>
                <h3><?= e($o['title']) ?></h3>
                <?php if (!empty($o['event_name'])): ?>
                <p>📅 <?= e($o['event_name']) ?>
                    <?php if (!empty($o['event_date'])): ?> · <?= date('d.m.Y', strtotime($o['event_date'])) ?><?php endif; ?>
                    <?php if (!empty($o['event_location'])): ?> · 📍 <?= e($o['event_location']) ?><?php endif; ?>
                </p>
                <?php endif; ?>
            </div>
            <span class="mp-stage-badge mp-stage-<?= e($st['color']) ?>"><?= e($st['label']) ?></span>
        </div>
        <div class="mp-progress">
            <div class="mp-progress-bar" style="width: <?= (int)$o['progress'] ?>%"></div>
        </div>
        <div class="mp-order-row-foot">
            <span class="text-muted small"><?= (int)$o['progress'] ?>% tamamlandı</span>
            <?php if (!empty($o['total_amount'])): ?>
            <span class="mp-amount"><?= e($o['currency']) ?> <?= number_format((float)$o['total_amount'], 0, ',', '.') ?></span>
            <?php endif; ?>
            <span class="mp-arrow">→</span>
        </div>
    </a>
    <?php endforeach; ?>
</div>
<?php endif; ?>

<style>
.mp-page-head { margin-bottom: 2rem; }
.mp-page-head h1 { font-size: 1.75rem; font-weight: 700; margin: 0 0 .25rem; color: #1d1d1f; }
.mp-page-head p { color: #6e6e73; margin: 0; }
.mp-orders-list { display: flex; flex-direction: column; gap: 1rem; }
.mp-order-row {
    background: #fff; border-radius: 16px; padding: 1.5rem;
    border: 1px solid #e5e5e7; text-decoration: none; color: inherit;
    transition: all .25s; display: block;
}
.mp-order-row:hover { border-color: #E30613; box-shadow: 0 8px 20px rgba(0,0,0,.05); }
.mp-order-row-head { display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; margin-bottom: 1rem; }
.mp-order-row h3 { font-size: 1.125rem; font-weight: 600; margin: .25rem 0; color: #1d1d1f; }
.mp-order-row p { color: #6e6e73; font-size: .875rem; margin: 0; }
.mp-order-no { font-family: monospace; font-size: .75rem; color: #86868b; letter-spacing: .05em; }
.mp-order-row-foot {
    display: flex; align-items: center; justify-content: space-between; gap: 1rem;
    margin-top: .75rem; font-size: .875rem;
}
.mp-amount { font-weight: 700; color: #1d1d1f; }
.mp-arrow { color: #E30613; font-size: 1.25rem; }
.text-muted { color: #86868b; }
.small { font-size: .75rem; }

.mp-stage-badge { font-size: .75rem; font-weight: 600; padding: .35rem .75rem; border-radius: 100px; background: #f5f5f7; color: #1d1d1f; white-space: nowrap; }
.mp-stage-blue { background: #DBEAFE; color: #1E40AF; } .mp-stage-cyan { background: #CFFAFE; color: #155E75; }
.mp-stage-orange { background: #FED7AA; color: #9A3412; } .mp-stage-teal { background: #CCFBF1; color: #115E59; }
.mp-stage-yellow { background: #FEF3C7; color: #92400E; } .mp-stage-lime { background: #ECFCCB; color: #3F6212; }
.mp-stage-indigo { background: #E0E7FF; color: #3730A3; } .mp-stage-purple { background: #F3E8FF; color: #6B21A8; }
.mp-stage-green { background: #D1FAE5; color: #065F46; } .mp-stage-red { background: #FEE2E2; color: #991B1B; }
.mp-progress { height: 6px; background: #f5f5f7; border-radius: 100px; overflow: hidden; }
.mp-progress-bar { height: 100%; background: linear-gradient(90deg, #E30613, #ff6b35); border-radius: 100px; }
.mp-empty { background: #fff; border-radius: 16px; padding: 3rem; text-align: center; border: 1px solid #e5e5e7; }
.mp-empty p { margin: .25rem 0; }
</style>
