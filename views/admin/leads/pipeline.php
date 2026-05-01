<?php
$pageTitle = 'Lead Pipeline';
$pretitle  = 'CRM — Satış Hunisi';
$headerActions = '
    <a href="/admin/leads" class="btn btn-outline-secondary me-2"><i class="ti ti-list me-1"></i>Liste</a>
    <a href="/admin/leads/create" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Yeni Lead</a>
';

// Calculate totals per column
$colTotals = [];
$grandTotal = 0;
$grandCount = 0;
foreach ($columns as $key => $col) {
    $sum = 0;
    foreach ($col['leads'] as $l) {
        if (!empty($l['expected_value'])) $sum += (float)$l['expected_value'];
    }
    $colTotals[$key] = $sum;
    if (!in_array($key, ['won','lost'], true)) {
        $grandTotal += $sum;
        $grandCount += count($col['leads']);
    }
}
$wonTotal  = $colTotals['won']  ?? 0;
$lostTotal = $colTotals['lost'] ?? 0;
?>

<!-- Summary Bar -->
<div class="pd-summary">
    <div class="pd-summary-stat">
        <div class="pd-summary-num"><?= $grandCount ?></div>
        <div class="pd-summary-label">Aktif Lead</div>
    </div>
    <div class="pd-summary-stat pd-summary-pipeline">
        <div class="pd-summary-num">€ <?= number_format($grandTotal, 0, ',', '.') ?></div>
        <div class="pd-summary-label">Pipeline Değeri</div>
    </div>
    <div class="pd-summary-stat pd-summary-won">
        <div class="pd-summary-num">€ <?= number_format($wonTotal, 0, ',', '.') ?></div>
        <div class="pd-summary-label">Kazanılan <?= count($columns['won']['leads'] ?? []) ?></div>
    </div>
    <div class="pd-summary-stat pd-summary-lost">
        <div class="pd-summary-num">€ <?= number_format($lostTotal, 0, ',', '.') ?></div>
        <div class="pd-summary-label">Kaybedilen <?= count($columns['lost']['leads'] ?? []) ?></div>
    </div>
    <div class="pd-summary-stat pd-summary-rate">
        <?php
        $totalDeals = count($columns['won']['leads'] ?? []) + count($columns['lost']['leads'] ?? []);
        $winRate = $totalDeals > 0 ? round((count($columns['won']['leads'] ?? []) / $totalDeals) * 100) : 0;
        ?>
        <div class="pd-summary-num">%<?= $winRate ?></div>
        <div class="pd-summary-label">Kazanma Oranı</div>
    </div>
</div>

<!-- Pipeline Board -->
<div class="pd-board">
    <?php foreach ($columns as $key => $col):
        $cfg = $col['config'];
        $count = count($col['leads']);
        $sum = $colTotals[$key] ?? 0;
    ?>
    <div class="pd-col" data-stage="<?= e($key) ?>">
        <div class="pd-col-head pd-col-head-<?= e($cfg['color']) ?>">
            <div class="pd-col-title">
                <span class="pd-col-name"><?= e($cfg['label']) ?></span>
                <span class="pd-col-count"><?= $count ?></span>
            </div>
            <div class="pd-col-total">€ <?= number_format($sum, 0, ',', '.') ?></div>
        </div>
        <div class="pd-col-body">
            <?php if (empty($col['leads'])): ?>
            <div class="pd-empty">Bu aşamada lead yok</div>
            <?php else: foreach ($col['leads'] as $l):
                $tp = \App\Models\Lead::TEMPERATURES[$l['temperature']] ?? ['icon'=>'•','label'=>$l['temperature']];
                $tags = !empty($l['tags_json']) ? (json_decode((string)$l['tags_json'], true) ?: []) : [];
                $hasNextAction = !empty($l['next_action']);
                $isOverdue = $hasNextAction && !empty($l['next_action_date']) && strtotime($l['next_action_date']) < time();
            ?>
            <a href="/admin/leads/<?= $l['id'] ?>" class="pd-card" draggable="true" data-lead-id="<?= $l['id'] ?>">
                <div class="pd-card-head">
                    <div class="pd-card-name">
                        <strong><?= e($l['name']) ?></strong>
                        <span class="pd-temp" title="<?= e($tp['label']) ?>"><?= $tp['icon'] ?></span>
                    </div>
                    <?php if (!empty($l['expected_value'])): ?>
                    <div class="pd-card-value"><?= e($l['currency']) ?> <?= number_format((float)$l['expected_value'], 0, ',', '.') ?></div>
                    <?php endif; ?>
                </div>

                <?php if (!empty($l['company'])): ?>
                <div class="pd-card-company"><?= e($l['company']) ?></div>
                <?php endif; ?>

                <?php if (!empty($l['event_name'])): ?>
                <div class="pd-card-event">
                    📅 <?= e($l['event_name']) ?>
                    <?php if (!empty($l['event_date'])): ?> · <?= date('d.m', strtotime($l['event_date'])) ?><?php endif; ?>
                </div>
                <?php endif; ?>

                <!-- Score bar -->
                <div class="pd-score-bar">
                    <div class="pd-score-fill" style="width:<?= (int)$l['score'] ?>%; background:<?= ($l['score'] ?? 0) >= 70 ? '#10b981' : (($l['score'] ?? 0) >= 40 ? '#f59e0b' : '#ef4444') ?>"></div>
                </div>

                <!-- Tags -->
                <?php if (!empty($tags)): ?>
                <div class="pd-tags">
                    <?php foreach (array_slice($tags, 0, 3) as $t): ?>
                    <span class="pd-tag">#<?= e($t) ?></span>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>

                <!-- Bottom info -->
                <div class="pd-card-foot">
                    <div class="pd-card-actions">
                        <?php if (!empty($l['phone'])): ?>
                        <span class="pd-action-icon" title="Telefon"><i class="ti ti-phone"></i></span>
                        <?php endif; ?>
                        <?php if (!empty($l['email'])): ?>
                        <span class="pd-action-icon" title="E-posta"><i class="ti ti-mail"></i></span>
                        <?php endif; ?>
                        <?php if ((int)$l['has_order'] === 1): ?>
                        <span class="pd-action-icon pd-has-order" title="Sipariş var">✓</span>
                        <?php endif; ?>
                    </div>
                    <?php if ($hasNextAction): ?>
                    <div class="pd-next-action <?= $isOverdue ? 'pd-overdue' : '' ?>" title="<?= e($l['next_action']) ?>">
                        <i class="ti ti-bell"></i>
                        <?php if (!empty($l['next_action_date'])): ?>
                        <span><?= date('d.m', strtotime($l['next_action_date'])) ?></span>
                        <?php endif; ?>
                    </div>
                    <?php else: ?>
                    <div class="pd-time"><?= timeAgo($l['updated_at']) ?></div>
                    <?php endif; ?>
                </div>
            </a>
            <?php endforeach; endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
</div>

<style>
/* ═══════════════════════════════════════════════════════════════
   PIPEDRIVE-STYLE PIPELINE
═══════════════════════════════════════════════════════════════ */
.pd-summary {
    display: grid; grid-template-columns: repeat(5, 1fr);
    gap: 1rem; margin-bottom: 1.5rem;
}
.pd-summary-stat {
    background: var(--tblr-bg-surface, #fff);
    border: 1px solid var(--tblr-border-color, #e5e5e7);
    border-radius: 12px; padding: 1.25rem;
}
.pd-summary-num {
    font-size: 1.625rem; font-weight: 700;
    line-height: 1; color: var(--tblr-body-color, #1d1d1f);
    margin-bottom: .25rem;
}
.pd-summary-label {
    font-size: .75rem; color: var(--tblr-secondary, #6e6e73);
    text-transform: uppercase; letter-spacing: .05em; font-weight: 600;
}
.pd-summary-pipeline { border-top: 3px solid #0066cc; }
.pd-summary-pipeline .pd-summary-num { color: #0066cc; }
.pd-summary-won      { border-top: 3px solid #10b981; }
.pd-summary-won .pd-summary-num { color: #10b981; }
.pd-summary-lost     { border-top: 3px solid #ef4444; }
.pd-summary-lost .pd-summary-num { color: #ef4444; }
.pd-summary-rate     { border-top: 3px solid #E30613; }
.pd-summary-rate .pd-summary-num { color: #E30613; }

@media (max-width: 1024px) { .pd-summary { grid-template-columns: repeat(2, 1fr); } }

/* Board */
.pd-board {
    display: flex;
    gap: .75rem;
    overflow-x: auto;
    padding-bottom: 1rem;
    min-height: 70vh;
}

/* Column */
.pd-col {
    flex: 0 0 280px;
    min-width: 280px;
    max-width: 280px;
    display: flex;
    flex-direction: column;
    background: var(--tblr-bg-surface-secondary, #f5f5f7);
    border-radius: 12px;
    overflow: hidden;
}
.pd-col-head {
    padding: .75rem 1rem;
    background: #fff;
    border-bottom: 3px solid currentColor;
    display: flex;
    flex-direction: column;
    gap: .25rem;
}
.pd-col-head-blue   { color: #0066cc; }
.pd-col-head-azure  { color: #0099cc; }
.pd-col-head-cyan   { color: #06b6d4; }
.pd-col-head-orange { color: #ff6b35; }
.pd-col-head-yellow { color: #f59e0b; }
.pd-col-head-green  { color: #10b981; }
.pd-col-head-red    { color: #ef4444; }
.pd-col-head-gray   { color: #6e6e73; }
.pd-col-title {
    display: flex; align-items: center; justify-content: space-between;
    font-weight: 700; font-size: .875rem;
}
.pd-col-name { color: #1d1d1f; }
.pd-col-count {
    background: #f5f5f7; color: #1d1d1f;
    padding: .15rem .55rem; border-radius: 100px;
    font-size: .75rem;
}
.pd-col-total {
    font-size: .8125rem; font-weight: 600;
    color: currentColor; opacity: .9;
}

.pd-col-body {
    flex: 1; padding: .5rem;
    display: flex; flex-direction: column; gap: .5rem;
    overflow-y: auto; max-height: calc(100vh - 280px);
}
.pd-empty {
    text-align: center; padding: 2rem 1rem;
    color: #86868b; font-size: .8125rem;
    border: 2px dashed #d2d2d7; border-radius: 8px;
}

/* Card */
.pd-card {
    display: block;
    background: #fff;
    border-radius: 8px;
    padding: .75rem;
    text-decoration: none;
    color: inherit;
    border: 1px solid transparent;
    box-shadow: 0 1px 3px rgba(0,0,0,.06);
    transition: all .2s;
    cursor: pointer;
    position: relative;
}
.pd-card:hover {
    border-color: #E30613;
    box-shadow: 0 4px 12px rgba(0,0,0,.1);
    color: inherit;
    transform: translateY(-1px);
}

.pd-card-head {
    display: flex; align-items: flex-start; justify-content: space-between;
    gap: .5rem; margin-bottom: .375rem;
}
.pd-card-name {
    display: flex; align-items: center; gap: .375rem;
    font-size: .875rem; line-height: 1.2;
}
.pd-card-name strong { color: #1d1d1f; font-weight: 600; }
.pd-temp { font-size: .85rem; }
.pd-card-value {
    font-size: .8125rem; font-weight: 700;
    color: #10b981; white-space: nowrap;
}

.pd-card-company {
    font-size: .75rem; color: #6e6e73;
    margin-bottom: .25rem;
}
.pd-card-event {
    font-size: .7rem; color: #1d1d1f;
    background: #fef3c7; padding: .15rem .4rem;
    border-radius: 4px; display: inline-block;
    margin-bottom: .5rem;
}

.pd-score-bar {
    height: 3px; background: #f5f5f7;
    border-radius: 100px; margin: .375rem 0; overflow: hidden;
}
.pd-score-fill { height: 100%; transition: width .25s; }

.pd-tags {
    display: flex; flex-wrap: wrap; gap: .25rem;
    margin: .375rem 0;
}
.pd-tag {
    font-size: .65rem; color: #6e6e73;
    background: #f5f5f7; padding: .1rem .4rem;
    border-radius: 4px;
}

.pd-card-foot {
    display: flex; align-items: center; justify-content: space-between;
    margin-top: .5rem; padding-top: .375rem;
    border-top: 1px solid #f5f5f7;
}
.pd-card-actions { display: flex; gap: .375rem; align-items: center; }
.pd-action-icon {
    color: #86868b; font-size: .85rem;
    width: 22px; height: 22px;
    display: inline-flex; align-items: center; justify-content: center;
    border-radius: 50%; background: #f5f5f7;
}
.pd-has-order { background: #d1fae5; color: #065f46; font-weight: 700; }

.pd-time {
    font-size: .65rem; color: #86868b;
}
.pd-next-action {
    font-size: .65rem; color: #1d1d1f;
    background: #fef3c7; padding: .15rem .4rem;
    border-radius: 4px;
    display: flex; align-items: center; gap: .2rem;
}
.pd-next-action.pd-overdue {
    background: #fee2e2; color: #991b1b;
    animation: pulse-warn 2s infinite;
}
@keyframes pulse-warn {
    0%, 100% { opacity: 1; }
    50% { opacity: .7; }
}

/* Drag-drop visual */
.pd-card.dragging { opacity: .4; transform: rotate(2deg); }
.pd-col.drag-over { background: rgba(227,6,19,.05); }
.pd-col.drag-over .pd-col-body { background: rgba(227,6,19,.05); border: 2px dashed #E30613; border-radius: 8px; }

/* Scrollbar styling */
.pd-board::-webkit-scrollbar { height: 10px; }
.pd-col-body::-webkit-scrollbar { width: 6px; }
.pd-board::-webkit-scrollbar-thumb,
.pd-col-body::-webkit-scrollbar-thumb { background: #d2d2d7; border-radius: 10px; }

@media (max-width: 768px) {
    .pd-col { flex: 0 0 260px; min-width: 260px; }
}
</style>

<script>
// Drag & drop between columns - quick stage change
(function() {
    const cards = document.querySelectorAll('.pd-card');
    const cols  = document.querySelectorAll('.pd-col');
    let draggedCard = null;

    cards.forEach(card => {
        card.addEventListener('dragstart', (e) => {
            draggedCard = card;
            card.classList.add('dragging');
            e.dataTransfer.effectAllowed = 'move';
        });
        card.addEventListener('dragend', () => {
            card.classList.remove('dragging');
        });
    });

    cols.forEach(col => {
        col.addEventListener('dragover', (e) => {
            e.preventDefault();
            col.classList.add('drag-over');
        });
        col.addEventListener('dragleave', () => col.classList.remove('drag-over'));
        col.addEventListener('drop', async (e) => {
            e.preventDefault();
            col.classList.remove('drag-over');
            if (!draggedCard) return;
            const newStage = col.dataset.stage;
            const leadId   = draggedCard.dataset.leadId;
            const oldCol   = draggedCard.closest('.pd-col');
            if (oldCol === col) return;

            // Move visually first
            col.querySelector('.pd-col-body').appendChild(draggedCard);

            // Update on server
            try {
                const fd = new FormData();
                fd.append('status', newStage);
                const res = await fetch('/admin/leads/' + leadId + '/status', {
                    method: 'POST', body: fd,
                    headers: {'X-Requested-With': 'XMLHttpRequest'}
                });
                if (!res.ok) throw new Error('failed');
            } catch(err) {
                alert('Aşama güncellenemedi, sayfayı yenileyin.');
            }
        });
    });
})();
</script>
