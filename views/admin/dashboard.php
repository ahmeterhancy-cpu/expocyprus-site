<?php $pageTitle = 'Dashboard'; $pretitle = 'Genel Bakış'; ?>

<!-- Stats Cards -->
<div class="row row-deck row-cards mb-4">
    <div class="col-sm-6 col-xl-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon red"><i class="ti ti-mail fs-2"></i></div>
                    <div>
                        <div class="text-muted small">Bugünkü Başvuru</div>
                        <div class="h2 mb-0 fw-bold"><?= $stats['submissions_today'] ?></div>
                    </div>
                    <?php if ($stats['unread'] > 0): ?>
                    <span class="badge bg-danger ms-auto"><?= $stats['unread'] ?> okunmamış</span>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon blue"><i class="ti ti-tools fs-2"></i></div>
                    <div>
                        <div class="text-muted small">Hizmetler</div>
                        <div class="h2 mb-0 fw-bold"><?= $stats['services'] ?></div>
                    </div>
                    <a href="/admin/services" class="btn btn-sm btn-outline-secondary ms-auto">Yönet</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon green"><i class="ti ti-calendar-event fs-2"></i></div>
                    <div>
                        <div class="text-muted small">Fuarlar</div>
                        <div class="h2 mb-0 fw-bold"><?= $stats['fairs'] ?></div>
                    </div>
                    <a href="/admin/fairs" class="btn btn-sm btn-outline-secondary ms-auto">Yönet</a>
                </div>
            </div>
        </div>
    </div>

    <div class="col-sm-6 col-xl-3">
        <div class="card card-stats">
            <div class="card-body">
                <div class="d-flex align-items-center gap-3">
                    <div class="stat-icon orange"><i class="ti ti-photo fs-2"></i></div>
                    <div>
                        <div class="text-muted small">Medya Dosyası</div>
                        <div class="h2 mb-0 fw-bold"><?= $stats['media'] ?></div>
                    </div>
                    <a href="/admin/media" class="btn btn-sm btn-outline-secondary ms-auto">Yönet</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart + Recent Submissions -->
<div class="row row-deck row-cards">
    <!-- Monthly Chart -->
    <div class="col-lg-7">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-chart-bar me-2"></i>Son 6 Ay Başvurular</h3>
            </div>
            <div class="card-body">
                <canvas id="submissionsChart" height="260"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-lg-5">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title"><i class="ti ti-bolt me-2"></i>Hızlı İşlemler</h3>
            </div>
            <div class="card-body p-0">
                <div class="list-group list-group-flush">
                    <a href="/admin/services/create" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4">
                        <div class="stat-icon blue" style="width:36px;height:36px;min-width:36px"><i class="ti ti-plus"></i></div>
                        <div>
                            <div class="fw-medium">Yeni Hizmet Ekle</div>
                            <div class="text-muted small">6 hizmet hattından birini ekle/güncelle</div>
                        </div>
                        <i class="ti ti-chevron-right ms-auto text-muted"></i>
                    </a>
                    <a href="/admin/fairs/create" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4">
                        <div class="stat-icon green" style="width:36px;height:36px;min-width:36px"><i class="ti ti-plus"></i></div>
                        <div>
                            <div class="fw-medium">Yeni Fuar Ekle</div>
                            <div class="text-muted small">Tarih, konum ve içeriğiyle birlikte</div>
                        </div>
                        <i class="ti ti-chevron-right ms-auto text-muted"></i>
                    </a>
                    <a href="/admin/media" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4">
                        <div class="stat-icon orange" style="width:36px;height:36px;min-width:36px"><i class="ti ti-upload"></i></div>
                        <div>
                            <div class="fw-medium">Medya Yükle</div>
                            <div class="text-muted small">Fotoğraf, logo, döküman</div>
                        </div>
                        <i class="ti ti-chevron-right ms-auto text-muted"></i>
                    </a>
                    <a href="/admin/submissions" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4">
                        <div class="stat-icon red" style="width:36px;height:36px;min-width:36px"><i class="ti ti-mail"></i></div>
                        <div>
                            <div class="fw-medium">Tüm Başvurular</div>
                            <div class="text-muted small">CSV'ye aktarma seçeneğiyle</div>
                        </div>
                        <i class="ti ti-chevron-right ms-auto text-muted"></i>
                    </a>
                    <a href="/admin/settings" class="list-group-item list-group-item-action d-flex align-items-center gap-3 py-3 px-4">
                        <div class="stat-icon" style="width:36px;height:36px;min-width:36px;background:rgba(148,163,184,.1);color:#94a3b8"><i class="ti ti-settings"></i></div>
                        <div>
                            <div class="fw-medium">Site Ayarları</div>
                            <div class="text-muted small">İletişim, sosyal medya, SMTP</div>
                        </div>
                        <i class="ti ti-chevron-right ms-auto text-muted"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Submissions Table -->
<div class="row mt-4">
    <div class="col-12">
        <div class="card">
            <div class="card-header d-flex align-items-center">
                <h3 class="card-title me-auto"><i class="ti ti-inbox me-2"></i>Son Başvurular</h3>
                <a href="/admin/submissions" class="btn btn-sm btn-outline-primary">Tümünü Gör</a>
                <a href="/admin/submissions/export" class="btn btn-sm btn-outline-secondary ms-2">
                    <i class="ti ti-download me-1"></i>CSV
                </a>
            </div>
            <div class="table-responsive">
                <table class="table table-vcenter card-table table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Form Tipi</th>
                            <th>İsim / E-posta</th>
                            <th>Tarih</th>
                            <th>Durum</th>
                            <th class="w-1"></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($recentSubmissions as $sub):
                            $data = json_decode($sub['data_json'] ?? '{}', true) ?: [];
                            $name  = $data['name'] ?? $data['ad_soyad'] ?? $data['isim'] ?? '—';
                            $email = $data['email'] ?? '—';
                            $typeLabels = [
                                'iletisim'          => 'İletişim',
                                'teklif'            => 'Teklif Talebi',
                                'stand'             => 'Stand Teklifi',
                                'fuar_katilim'      => 'Fuar Katılım',
                                'sponsor'           => 'Sponsor Teklifi',
                            ];
                            $typeLabel = $typeLabels[$sub['form_type']] ?? $sub['form_type'];
                        ?>
                        <tr class="<?= !$sub['is_read'] ? 'fw-semibold' : '' ?>">
                            <td class="text-muted"><?= $sub['id'] ?></td>
                            <td><span class="badge bg-blue-lt"><?= e($typeLabel) ?></span></td>
                            <td>
                                <div><?= e($name) ?></div>
                                <small class="text-muted"><?= e($email) ?></small>
                            </td>
                            <td class="text-muted"><?= timeAgo($sub['created_at']) ?></td>
                            <td>
                                <?php if (!$sub['is_read']): ?>
                                    <span class="badge bg-danger-lt text-danger">Okunmamış</span>
                                <?php else: ?>
                                    <span class="badge bg-success-lt text-success">Okundu</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <a href="/admin/submissions/<?= $sub['id'] ?>" class="btn btn-sm">Görüntüle</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php if (empty($recentSubmissions)): ?>
                        <tr><td colspan="6" class="text-center text-muted py-4">Henüz başvuru yok</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$chartLabels = json_encode(array_column($monthlyData, 'month'));
$chartData   = json_encode(array_map('intval', array_column($monthlyData, 'total')));
$extraScripts = <<<JS
<script>
(function() {
    const ctx = document.getElementById('submissionsChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {$chartLabels},
            datasets: [{
                label: 'Başvuru',
                data: {$chartData},
                backgroundColor: 'rgba(227,6,19,.7)',
                borderColor: '#E30613',
                borderWidth: 1,
                borderRadius: 6,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: {
                y: { beginAtZero: true, ticks: { stepSize: 1 }, grid: { color: 'rgba(255,255,255,.05)' } },
                x: { grid: { display: false } }
            }
        }
    });
})();
</script>
JS;
?>
