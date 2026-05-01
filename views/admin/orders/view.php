<?php
$pageTitle = 'Sipariş #' . ($order['order_no'] ?? '');
$pretitle  = 'Sipariş Detayı';

$statusMap = [
    'pending'           => 'Beklemede',
    'awaiting_transfer' => 'Havale Bekleniyor',
    'paid'              => 'Ödendi',
    'processing'        => 'İşleniyor',
    'completed'         => 'Tamamlandı',
    'cancelled'         => 'İptal',
];

$payMap = [
    'bank_transfer' => 'Havale / EFT',
    'credit_card'   => 'Kredi Kartı',
];

$symbols = ['EUR'=>'€','USD'=>'$','GBP'=>'£','TRY'=>'₺'];
$sym = $symbols[$order['currency'] ?? 'EUR'] ?? ($order['currency'] ?? '€');
?>

<div class="row g-3">
    <!-- LEFT: Customer & Items -->
    <div class="col-lg-8">

        <!-- Customer Info -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-user me-2"></i>Müşteri Bilgileri</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="text-muted small">Ad Soyad</div>
                        <div class="fw-semibold"><?= e($order['customer_name'] ?? '—') ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">E-posta</div>
                        <div><a href="mailto:<?= e($order['customer_email'] ?? '') ?>"><?= e($order['customer_email'] ?? '—') ?></a></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Telefon</div>
                        <div><?= e($order['customer_phone'] ?? '—') ?></div>
                    </div>
                    <div class="col-md-6">
                        <div class="text-muted small">Firma</div>
                        <div><?= e($order['customer_company'] ?? '—') ?></div>
                    </div>
                    <?php if (!empty($order['customer_address'])): ?>
                    <div class="col-12">
                        <div class="text-muted small">Adres</div>
                        <div><?= nl2br(e($order['customer_address'])) ?></div>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <!-- Fair Info -->
        <?php if (!empty($order['fair_name']) || !empty($order['fair_date']) || !empty($order['fair_location'])): ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-calendar-event me-2"></i>Etkinlik Bilgileri</h3>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="text-muted small">Fuar Adı</div>
                        <div><?= e($order['fair_name'] ?? '—') ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">Tarih</div>
                        <div><?= !empty($order['fair_date']) ? date('d.m.Y', strtotime($order['fair_date'])) : '—' ?></div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-muted small">Konum</div>
                        <div><?= e($order['fair_location'] ?? '—') ?></div>
                    </div>
                </div>
            </div>
        </div>
        <?php endif; ?>

        <!-- Items -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-package me-2"></i>Sipariş Kalemleri</h3>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table">
                    <thead>
                        <tr>
                            <th>Model</th>
                            <th>Boyut</th>
                            <th class="text-end">Birim</th>
                            <th class="text-end">Adet</th>
                            <th class="text-end">Toplam</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach (($items ?? []) as $it):
                            $rowSub = (float)($it['price'] ?? 0) * (int)($it['qty'] ?? 0);
                        ?>
                        <tr>
                            <td>
                                <div class="fw-semibold"><?= e($it['model_no'] ?? '') ?></div>
                                <small class="text-muted"><?= e($it['name_tr'] ?? '') ?></small>
                            </td>
                            <td class="text-muted small"><?= e($it['dimensions'] ?? '') ?></td>
                            <td class="text-end"><?= $sym ?> <?= number_format((float)($it['price'] ?? 0), 2, ',', '.') ?></td>
                            <td class="text-end">×<?= (int)($it['qty'] ?? 0) ?></td>
                            <td class="text-end fw-semibold"><?= $sym ?> <?= number_format($rowSub, 2, ',', '.') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-end text-muted">Ara Toplam</td>
                            <td class="text-end"><?= $sym ?> <?= number_format((float)($order['subtotal'] ?? 0), 2, ',', '.') ?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end text-muted">KDV (%<?= (int)($order['vat_rate'] ?? 0) ?>)</td>
                            <td class="text-end">—</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="text-end fw-bold">Toplam</td>
                            <td class="text-end fw-bold text-red"><?= $sym ?> <?= number_format((float)($order['total'] ?? 0), 2, ',', '.') ?></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <!-- Notes -->
        <?php if (!empty($order['notes'])): ?>
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-note me-2"></i>Müşteri Notu</h3>
            </div>
            <div class="card-body"><?= nl2br(e($order['notes'])) ?></div>
        </div>
        <?php endif; ?>
    </div>

    <!-- RIGHT: Status & Payment -->
    <div class="col-lg-4">
        <!-- Status -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Durum</h3>
            </div>
            <div class="card-body">
                <form action="/admin/orders/<?= (int)$order['id'] ?>/status" method="POST">
                    <label class="form-label">Sipariş Durumu</label>
                    <select name="status" class="form-select mb-3">
                        <?php foreach ($statusMap as $key => $label): ?>
                        <option value="<?= e($key) ?>" <?= ($order['status'] ?? '') === $key ? 'selected' : '' ?>>
                            <?= e($label) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="ti ti-check me-1"></i>Durumu Güncelle
                    </button>
                </form>
            </div>
        </div>

        <!-- Payment -->
        <div class="card mb-3">
            <div class="card-header">
                <h3 class="card-title">Ödeme Bilgisi</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <div class="text-muted small">Ödeme Yöntemi</div>
                    <div class="fw-semibold"><?= e($payMap[$order['payment_method'] ?? ''] ?? ($order['payment_method'] ?? '—')) ?></div>
                </div>
                <div class="mb-2">
                    <div class="text-muted small">Ödeme Durumu</div>
                    <div><?= e($order['payment_status'] ?? '—') ?></div>
                </div>
                <?php if (!empty($order['payment_ref'])): ?>
                <div class="mb-2">
                    <div class="text-muted small">Referans</div>
                    <div><code><?= e($order['payment_ref']) ?></code></div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Meta -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Meta</h3>
            </div>
            <div class="card-body">
                <div class="mb-2">
                    <div class="text-muted small">Sipariş Tarihi</div>
                    <div><?= e($order['created_at'] ?? '—') ?></div>
                </div>
                <?php if (!empty($order['ip'])): ?>
                <div class="mb-2">
                    <div class="text-muted small">IP</div>
                    <div><code><?= e($order['ip']) ?></code></div>
                </div>
                <?php endif; ?>
                <hr>
                <form action="/admin/orders/<?= (int)$order['id'] ?>/delete" method="POST"
                      onsubmit="return confirm('Bu siparişi silmek istediğinizden emin misiniz?')">
                    <button class="btn btn-outline-danger w-100">
                        <i class="ti ti-trash me-1"></i>Siparişi Sil
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="mt-3">
    <a href="/admin/orders" class="btn btn-link">← Tüm Siparişler</a>
</div>
