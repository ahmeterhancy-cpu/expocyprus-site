<?php
$pageTitle = 'Panelim | Expo Cyprus';
$stages = \App\Models\ProductionOrder::STAGES;
?>

<div class="mp-welcome">
    <h1>Hoş geldin, <span><?= e($_SESSION['member_contact'] ?? '') ?></span></h1>
    <p><?= e($_SESSION['member_company'] ?? '') ?></p>
</div>

<div class="mp-stats">
    <div class="mp-stat">
        <div class="mp-stat-num"><?= $stats['total'] ?></div>
        <div class="mp-stat-label">Toplam Sipariş</div>
    </div>
    <div class="mp-stat mp-stat-blue">
        <div class="mp-stat-num"><?= $stats['in_progress'] ?></div>
        <div class="mp-stat-label">Devam Eden</div>
    </div>
    <div class="mp-stat mp-stat-green">
        <div class="mp-stat-num"><?= $stats['completed'] ?></div>
        <div class="mp-stat-label">Tamamlanan</div>
    </div>
    <div class="mp-stat mp-stat-red">
        <div class="mp-stat-num"><?= $stats['cancelled'] ?></div>
        <div class="mp-stat-label">İptal Edilen</div>
    </div>
</div>

<div class="mp-section">
    <div class="mp-section-header">
        <h2>Son Siparişler</h2>
        <a href="/uye/siparisler" class="mp-link-arrow">Tüm siparişler →</a>
    </div>

    <?php if (empty($latest)): ?>
    <div class="mp-empty">
        <p>Henüz sipariş bulunmuyor.</p>
        <p class="text-muted">Yeni bir teklif almak için <a href="/teklif-al">Teklif İste</a> sayfasını ziyaret edin.</p>
    </div>
    <?php else: ?>
    <div class="mp-orders-grid">
        <?php foreach ($latest as $o):
            $st = $stages[$o['current_stage']] ?? ['label' => $o['current_stage'], 'color' => 'gray', 'icon' => 'ti-circle'];
        ?>
        <a href="/uye/siparis/<?= $o['id'] ?>" class="mp-order-card">
            <div class="mp-order-head">
                <span class="mp-order-no"><?= e($o['order_no']) ?></span>
                <span class="mp-stage-badge mp-stage-<?= e($st['color']) ?>"><?= e($st['label']) ?></span>
            </div>
            <h3 class="mp-order-title"><?= e($o['title']) ?></h3>
            <?php if (!empty($o['event_name'])): ?>
            <p class="mp-order-meta">📅 <?= e($o['event_name']) ?></p>
            <?php endif; ?>
            <div class="mp-progress">
                <div class="mp-progress-bar" style="width: <?= (int)$o['progress'] ?>%"></div>
            </div>
            <div class="mp-progress-text"><?= (int)$o['progress'] ?>% tamamlandı</div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>

<style>
.mp-welcome { margin-bottom: 2rem; }
.mp-welcome h1 {
    font-size: 1.75rem; font-weight: 700;
    margin: 0 0 .25rem; color: #1d1d1f;
}
.mp-welcome h1 span { color: #E30613; }
.mp-welcome p { color: #6e6e73; margin: 0; }

.mp-stats {
    display: grid; grid-template-columns: repeat(4, 1fr);
    gap: 1rem; margin-bottom: 2.5rem;
}
.mp-stat {
    background: #fff; border-radius: 16px;
    padding: 1.5rem; border: 1px solid #e5e5e7;
}
.mp-stat-num {
    font-size: 2.5rem; font-weight: 700;
    color: #1d1d1f; line-height: 1; margin-bottom: .25rem;
}
.mp-stat-label { color: #6e6e73; font-size: .875rem; }
.mp-stat-blue  .mp-stat-num { color: #0066CC; }
.mp-stat-green .mp-stat-num { color: #00875A; }
.mp-stat-red   .mp-stat-num { color: #E30613; }

.mp-section { margin-bottom: 2.5rem; }
.mp-section-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 1.25rem; }
.mp-section-header h2 { font-size: 1.25rem; font-weight: 700; margin: 0; color: #1d1d1f; }
.mp-link-arrow { color: #E30613; text-decoration: none; font-weight: 500; font-size: .875rem; }
.mp-link-arrow:hover { color: #c00510; }

.mp-empty {
    background: #fff; border-radius: 16px; padding: 3rem;
    text-align: center; border: 1px solid #e5e5e7;
}
.mp-empty p { margin: .25rem 0; }
.mp-empty .text-muted { color: #86868b; font-size: .875rem; }

.mp-orders-grid {
    display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 1rem;
}
.mp-order-card {
    background: #fff; border-radius: 16px; padding: 1.5rem;
    border: 1px solid #e5e5e7; text-decoration: none; color: inherit;
    transition: all .25s; display: block;
}
.mp-order-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 30px rgba(0,0,0,.08);
    border-color: #E30613;
}
.mp-order-head {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: .75rem; gap: .5rem;
}
.mp-order-no {
    font-family: 'JetBrains Mono', monospace, ui-monospace;
    font-size: .75rem; color: #86868b; letter-spacing: .05em;
}
.mp-stage-badge {
    font-size: .7rem; font-weight: 600;
    padding: .25rem .625rem; border-radius: 100px;
    background: #f5f5f7; color: #1d1d1f;
}
.mp-stage-blue   { background: #DBEAFE; color: #1E40AF; }
.mp-stage-cyan   { background: #CFFAFE; color: #155E75; }
.mp-stage-orange { background: #FED7AA; color: #9A3412; }
.mp-stage-teal   { background: #CCFBF1; color: #115E59; }
.mp-stage-yellow { background: #FEF3C7; color: #92400E; }
.mp-stage-lime   { background: #ECFCCB; color: #3F6212; }
.mp-stage-indigo { background: #E0E7FF; color: #3730A3; }
.mp-stage-purple { background: #F3E8FF; color: #6B21A8; }
.mp-stage-green  { background: #D1FAE5; color: #065F46; }
.mp-stage-red    { background: #FEE2E2; color: #991B1B; }

.mp-order-title {
    font-size: 1.0625rem; font-weight: 600;
    margin: 0 0 .5rem; color: #1d1d1f;
    line-height: 1.3;
}
.mp-order-meta {
    color: #6e6e73; font-size: .875rem;
    margin: 0 0 1rem;
}
.mp-progress {
    height: 6px; background: #f5f5f7;
    border-radius: 100px; overflow: hidden; margin-top: 1rem;
}
.mp-progress-bar {
    height: 100%; background: linear-gradient(90deg, #E30613, #ff6b35);
    border-radius: 100px; transition: width .35s;
}
.mp-progress-text {
    font-size: .75rem; color: #6e6e73; margin-top: .375rem;
}

@media (max-width: 768px) {
    .mp-stats { grid-template-columns: repeat(2, 1fr); }
}
</style>
