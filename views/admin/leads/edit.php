<?php
$pageTitle = ($isNew ?? true) ? 'Yeni Lead' : 'Lead\'i Düzenle';
$pretitle  = 'CRM';
$action    = ($isNew ?? true) ? '/admin/leads/store' : '/admin/leads/' . ($lead['id'] ?? 0) . '/update';
$l         = $lead ?? [];
$tags      = '';
if (!empty($l['tags_json'])) {
    $arr = json_decode((string)$l['tags_json'], true);
    if (is_array($arr)) $tags = implode(', ', $arr);
}
$headerActions = ($isNew ?? true)
    ? '<a href="/admin/leads" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Geri</a>'
    : '<a href="/admin/leads/' . ($l['id'] ?? 0) . '" class="btn btn-outline-secondary"><i class="ti ti-arrow-left me-1"></i>Lead\'e Dön</a>';
?>

<form action="<?= e($action) ?>" method="POST" enctype="multipart/form-data">
    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Müşteri Bilgileri</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label required">Ad Soyad</label>
                            <input type="text" name="name" class="form-control" value="<?= e($l['name'] ?? '') ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Firma</label>
                            <input type="text" name="company" class="form-control" value="<?= e($l['company'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">E-posta</label>
                            <input type="email" name="email" class="form-control" value="<?= e($l['email'] ?? '') ?>">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Telefon</label>
                            <input type="tel" name="phone" class="form-control" value="<?= e($l['phone'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Etkinlik Bilgileri</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Kongre / Fuar / Etkinlik</label>
                            <input type="text" name="event_name" class="form-control" value="<?= e($l['event_name'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Etkinlik Tarihi</label>
                            <input type="date" name="event_date" class="form-control" value="<?= e($l['event_date'] ?? '') ?>">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Etkinlik Yeri</label>
                            <input type="text" name="event_location" class="form-control" value="<?= e($l['event_location'] ?? '') ?>">
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Sipariş & Teklif</h3></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label class="form-label">Sipariş Var mı?</label>
                            <div class="form-check form-switch">
                                <input type="hidden" name="has_order" value="0">
                                <input type="checkbox" class="form-check-input" name="has_order" value="1" id="has_order" <?= !empty($l['has_order']) ? 'checked' : '' ?>>
                                <label class="form-check-label" for="has_order">Sipariş alındı</label>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label">Sipariş Referans</label>
                            <input type="text" name="order_ref" class="form-control" value="<?= e($l['order_ref'] ?? '') ?>" placeholder="Örn: SP-2026-001">
                        </div>
                        <div class="col-md-3">
                            <label class="form-label">Teklif Tutarı</label>
                            <input type="number" step="0.01" min="0" name="proposal_amount" class="form-control" value="<?= e($l['proposal_amount'] ?? '') ?>">
                        </div>
                        <div class="col-md-2">
                            <label class="form-label">Tahmini Değer</label>
                            <input type="number" step="0.01" min="0" name="expected_value" class="form-control" value="<?= e($l['expected_value'] ?? '') ?>">
                        </div>

                        <div class="col-12"><hr class="my-2"></div>

                        <div class="col-md-6">
                            <label class="form-label">
                                <i class="ti ti-file-upload me-1"></i>Teklif Dosyası (PDF / Görsel)
                            </label>
                            <input type="file" name="proposal_file" class="form-control"
                                   accept=".pdf,.doc,.docx,.jpg,.jpeg,.png,.webp">
                            <div class="form-hint">PDF, DOC, DOCX, JPG, PNG veya WEBP — max 25 MB</div>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Dosya Notu (opsiyonel)</label>
                            <input type="text" name="proposal_file_note" class="form-control"
                                   placeholder="Örn: v1 Taslak, Müşteri onaylı, Final...">
                            <div class="form-hint">Yüklenen dosya otomatik "Teklif" türü ile kaydedilir.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Notlar</h3></div>
                <div class="card-body">
                    <textarea name="notes" rows="5" class="form-control"><?= e($l['notes'] ?? '') ?></textarea>
                    <div class="form-hint">Genel notlar. Etkileşim notları için Lead detay sayfasındaki <strong>Aktiviteler</strong>'i kullanın.</div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Durum & Sıcaklık</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Durum</label>
                        <select name="status" class="form-select">
                            <?php foreach (\App\Models\Lead::STATUSES as $k => $cfg): ?>
                            <option value="<?= e($k) ?>" <?= ($l['status'] ?? 'new') === $k ? 'selected' : '' ?>><?= e($cfg['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Sıcaklık</label>
                        <select name="temperature" class="form-select">
                            <?php foreach (\App\Models\Lead::TEMPERATURES as $k => $cfg): ?>
                            <option value="<?= e($k) ?>" <?= ($l['temperature'] ?? 'warm') === $k ? 'selected' : '' ?>><?= $cfg['icon'] ?> <?= e($cfg['label']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Skor (0-100)</label>
                        <input type="range" min="0" max="100" name="score" value="<?= (int)($l['score'] ?? 50) ?>" class="form-range" oninput="this.nextElementSibling.value = this.value + ' / 100'">
                        <output><?= (int)($l['score'] ?? 50) ?> / 100</output>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Kaynak</label>
                        <select name="source" class="form-select">
                            <?php foreach (\App\Models\Lead::SOURCES as $k => $label): ?>
                            <option value="<?= e($k) ?>" <?= ($l['source'] ?? 'manual') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Bir Sonraki Adım</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Aksiyon</label>
                        <input type="text" name="next_action" class="form-control" value="<?= e($l['next_action'] ?? '') ?>" placeholder="Örn: Telefon görüşmesi yap">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Tarih / Saat</label>
                        <input type="datetime-local" name="next_action_date" class="form-control"
                               value="<?= e(!empty($l['next_action_date']) ? date('Y-m-d\TH:i', strtotime($l['next_action_date'])) : '') ?>">
                    </div>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header"><h3 class="card-title">Etiketler & Para</h3></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">Etiketler <small class="text-muted">(virgülle ayır)</small></label>
                        <input type="text" name="tags" class="form-control" value="<?= e($tags) ?>" placeholder="kongre, vip, acil">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Para Birimi</label>
                        <select name="currency" class="form-select">
                            <?php foreach (['EUR'=>'EUR (€)','TRY'=>'TRY (₺)','USD'=>'USD ($)','GBP'=>'GBP (£)'] as $c => $cl): ?>
                            <option value="<?= $c ?>" <?= ($l['currency'] ?? 'EUR') === $c ? 'selected' : '' ?>><?= $cl ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body d-flex justify-content-between align-items-center">
            <a href="/admin/leads" class="btn btn-outline-secondary">İptal</a>
            <button type="submit" class="btn btn-primary px-5">
                <i class="ti ti-device-floppy me-1"></i>
                <?= ($isNew ?? true) ? 'Lead Oluştur' : 'Değişiklikleri Kaydet' ?>
            </button>
        </div>
    </div>
</form>
