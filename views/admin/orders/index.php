<?php
$pageTitle = 'Siparişler';
$pretitle  = 'E-Ticaret Yönetimi';

$statusMap = [
    'pending'           => ['warning', 'Beklemede'],
    'awaiting_transfer' => ['info', 'Havale Bekleniyor'],
    'paid'              => ['success', 'Ödendi'],
    'processing'        => ['azure', 'İşleniyor'],
    'completed'         => ['success', 'Tamamlandı'],
    'cancelled'         => ['danger', 'İptal'],
];

$payMap = [
    'bank_transfer' => 'Havale / EFT',
    'credit_card'   => 'Kredi Kartı',
];

$symbols = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'];
?>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Tüm Siparişler</h3>
        <span class="ms-auto text-muted small">Toplam: <strong><?= count($orders ?? []) ?></strong></span>
    </div>
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
            <thead>
                <tr>
                    <th>Sipariş No</th>
                    <th>Müşteri</th>
                    <th>Tutar</th>
                    <th>Durum</th>
                    <th>Ödeme</th>
                    <th>Tarih</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (($orders ?? []) as $o):
                    $sym = $symbols[$o['currency'] ?? 'EUR'] ?? ($o['currency'] ?? '€');
                    [$badge, $label] = $statusMap[$o['status']] ?? ['secondary', $o['status']];
                ?>
                <tr>
                    <td>
                        <a href="/admin/orders/<?= (int)$o['id'] ?>" class="text-reset fw-bold">
                            <?= e($o['order_no']) ?>
                        </a>
                    </td>
                    <td>
                        <div><?= e($o['customer_name'] ?? '—') ?></div>
                        <small class="text-muted"><?= e($o['customer_email'] ?? '') ?></small>
                    </td>
                    <td class="fw-semibold">
                        <?= $sym ?> <?= number_format((float)($o['total'] ?? 0), 2, ',', '.') ?>
                    </td>
                    <td><span class="badge bg-<?= e($badge) ?>-lt"><?= e($label) ?></span></td>
                    <td class="text-muted small"><?= e($payMap[$o['payment_method'] ?? ''] ?? ($o['payment_method'] ?? '—')) ?></td>
                    <td class="text-muted small"><?= timeAgo($o['created_at'] ?? null) ?></td>
                    <td>
                        <div class="btn-group">
                            <a href="/admin/orders/<?= (int)$o['id'] ?>" class="btn btn-sm">Gör</a>
                            <form action="/admin/orders/<?= (int)$o['id'] ?>/delete" method="POST"
                                  onsubmit="return confirm('Bu siparişi silmek istediğinizden emin misiniz?')">
                                <button class="btn btn-sm btn-outline-danger"><i class="ti ti-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($orders)): ?>
                <tr>
                    <td colspan="7" class="text-center text-muted py-5">
                        <i class="ti ti-shopping-cart" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                        Henüz sipariş bulunmuyor
                    </td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
