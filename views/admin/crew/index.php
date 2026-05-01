<?php
$pageTitle = 'Unifex Crew Başvuruları';
$pretitle  = 'Saha Kadrosu Yönetimi';
$headerActions = '<a href="/admin/crew/export" class="btn btn-outline-secondary"><i class="ti ti-download me-1"></i>CSV İndir</a>';
?>

<!-- Status Pipeline -->
<div class="row row-deck row-cards mb-3">
    <?php foreach (\App\Models\CrewApplication::STATUSES as $key => $cfg):
        $count = $statusCounts[$key] ?? 0;
        $isActive = ($filters['status'] ?? '') === $key;
    ?>
    <div class="col-md col-sm-6">
        <a href="?status=<?= e($key) ?>" class="card text-decoration-none <?= $isActive ? 'border-primary' : '' ?>" style="<?= $isActive ? 'border-width:2px' : '' ?>">
            <div class="card-body py-2">
                <div class="d-flex align-items-center">
                    <span class="badge bg-<?= e($cfg['color']) ?>-lt me-2" style="font-size:.65rem"><?= e($cfg['label']) ?></span>
                    <span class="ms-auto h3 mb-0"><?= $count ?></span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>
</div>

<!-- Filters -->
<div class="card mb-3">
    <div class="card-body py-2">
        <form method="GET" class="row g-2 align-items-end">
            <div class="col-md-3">
                <label class="form-label small mb-1">Arama</label>
                <input type="text" name="q" class="form-control form-control-sm" value="<?= e($filters['q'] ?? '') ?>" placeholder="Ad, telefon, e-posta, instagram...">
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Pozisyon</label>
                <select name="position" class="form-select form-select-sm">
                    <option value="">Tümü</option>
                    <?php foreach (\App\Models\CrewApplication::POSITIONS as $k => $label): ?>
                    <option value="<?= e($k) ?>" <?= ($filters['position'] ?? '') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">Cinsiyet</label>
                <select name="gender" class="form-select form-select-sm">
                    <option value="">Tümü</option>
                    <option value="kadin" <?= ($filters['gender'] ?? '') === 'kadin' ? 'selected' : '' ?>>Kadın</option>
                    <option value="erkek" <?= ($filters['gender'] ?? '') === 'erkek' ? 'selected' : '' ?>>Erkek</option>
                    <option value="diger" <?= ($filters['gender'] ?? '') === 'diger' ? 'selected' : '' ?>>Diğer</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label small mb-1">Bölge</label>
                <select name="regions" class="form-select form-select-sm">
                    <option value="">Tümü</option>
                    <?php foreach (\App\Models\CrewApplication::REGIONS as $k => $label): ?>
                    <option value="<?= e($k) ?>" <?= ($filters['regions'] ?? '') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">Min Boy</label>
                <input type="number" name="min_height" class="form-control form-control-sm" value="<?= e($filters['min_height'] ?? '') ?>" placeholder="cm">
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">Max Boy</label>
                <input type="number" name="max_height" class="form-control form-control-sm" value="<?= e($filters['max_height'] ?? '') ?>" placeholder="cm">
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">Min Yaş</label>
                <input type="number" name="min_age" class="form-control form-control-sm" value="<?= e($filters['min_age'] ?? '') ?>">
            </div>
            <div class="col-md-1">
                <label class="form-label small mb-1">Max Yaş</label>
                <input type="number" name="max_age" class="form-control form-control-sm" value="<?= e($filters['max_age'] ?? '') ?>">
            </div>
            <div class="col-md-12 d-flex gap-2 mt-2 flex-wrap align-items-center">
                <select name="work_type" class="form-select form-select-sm" style="width:auto">
                    <option value="">Çalışma Şekli</option>
                    <?php foreach (\App\Models\CrewApplication::WORK_TYPES as $k => $label): ?>
                    <option value="<?= e($k) ?>" <?= ($filters['work_type'] ?? '') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
                <select name="education" class="form-select form-select-sm" style="width:auto">
                    <option value="">Eğitim</option>
                    <?php foreach (\App\Models\CrewApplication::EDUCATION_LEVELS as $k => $label): ?>
                    <option value="<?= e($k) ?>" <?= ($filters['education'] ?? '') === $k ? 'selected' : '' ?>><?= e($label) ?></option>
                    <?php endforeach; ?>
                </select>
                <input type="text" name="language" class="form-control form-control-sm" style="max-width:200px" value="<?= e($filters['language'] ?? '') ?>" placeholder="Dil (örn: ingilizce)">
                <button type="submit" class="btn btn-sm btn-primary">Filtrele</button>
                <?php if (array_filter($filters)): ?>
                <a href="/admin/crew" class="btn btn-sm btn-outline-secondary">Temizle</a>
                <?php endif; ?>
                <span class="ms-auto text-muted small">Toplam: <strong><?= $total ?? 0 ?></strong></span>
            </div>
        </form>
    </div>
</div>

<!-- Table -->
<div class="card">
    <div class="table-responsive">
        <table class="table table-vcenter card-table table-hover">
            <thead>
                <tr>
                    <th class="w-1">#</th>
                    <th class="w-1">Foto</th>
                    <th>Ad Soyad</th>
                    <th>Pozisyon</th>
                    <th>Cinsiyet / Yaş</th>
                    <th>Boy/Kilo</th>
                    <th>Bölge</th>
                    <th>İletişim</th>
                    <th>Diller</th>
                    <th>Durum</th>
                    <th>Tarih</th>
                    <th class="w-1"></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($data ?? [] as $a):
                    $st  = \App\Models\CrewApplication::STATUSES[$a['status']] ?? ['label' => $a['status'], 'color' => 'secondary'];
                    $posLabels = \App\Models\CrewApplication::positionLabels($a['positions'] ?? null);
                    $posDisplay = $posLabels ? implode(', ', array_slice($posLabels, 0, 2)) . (count($posLabels) > 2 ? ' +' . (count($posLabels) - 2) : '') : '—';
                    $age = !empty($a['birth_date']) ? floor((time() - strtotime($a['birth_date'])) / (365.25 * 86400)) : ($a['age'] ?? null);
                ?>
                <tr>
                    <td class="text-muted small"><?= $a['id'] ?></td>
                    <td>
                        <?php if (!empty($a['photo_portrait'])): ?>
                            <img src="<?= e($a['photo_portrait']) ?>" alt="" style="width:42px;height:42px;border-radius:50%;object-fit:cover">
                        <?php else: ?>
                            <span class="avatar avatar-sm" style="width:42px;height:42px"><?= mb_strtoupper(mb_substr($a['first_name'], 0, 1) . mb_substr($a['last_name'], 0, 1)) ?></span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <strong><?= e($a['first_name'] . ' ' . $a['last_name']) ?></strong>
                        <?php if (!empty($a['city'])): ?><br><small class="text-muted"><?= e($a['city']) ?></small><?php endif; ?>
                    </td>
                    <td><span class="badge bg-blue-lt" title="<?= e(implode(', ', $posLabels)) ?>"><?= e($posDisplay) ?></span><?php if (!empty($a['experience_years'])): ?><br><small class="text-muted"><?= (int)$a['experience_years'] ?> yıl deneyim</small><?php endif; ?></td>
                    <td class="small"><?= e(ucfirst($a['gender'] ?? '—')) ?><?php if ($age !== null): ?><br><span class="text-muted"><?= (int)$age ?> yaş</span><?php endif; ?></td>
                    <td class="small">
                        <?php if (!empty($a['height_cm'])): ?><?= (int)$a['height_cm'] ?> cm<?php endif; ?>
                        <?php if (!empty($a['weight_kg'])): ?><br><span class="text-muted"><?= (int)$a['weight_kg'] ?> kg</span><?php endif; ?>
                    </td>
                    <td class="small text-muted"><?= e(\App\Models\CrewApplication::REGIONS[$a['regions']] ?? '—') ?></td>
                    <td class="small">
                        <?= e($a['phone']) ?><br>
                        <span class="text-muted"><?= e($a['email']) ?></span>
                    </td>
                    <td class="small text-muted"><?= e($a['languages'] ?? '—') ?></td>
                    <td><span class="badge bg-<?= e($st['color']) ?>-lt"><?= e($st['label']) ?></span></td>
                    <td class="text-muted small"><?= timeAgo($a['created_at']) ?></td>
                    <td>
                        <a href="/admin/crew/<?= $a['id'] ?>" class="btn btn-sm">Aç</a>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php if (empty($data)): ?>
                <tr><td colspan="12" class="text-center text-muted py-5">
                    <i class="ti ti-users-group" style="font-size:2rem;display:block;margin-bottom:.5rem;opacity:.3"></i>
                    Crew başvurusu bulunamadı.
                </td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php if (($last_page ?? 1) > 1): ?>
    <div class="card-footer d-flex justify-content-end">
        <ul class="pagination mb-0">
            <?php
            $qs = $_GET; unset($qs['page']);
            $qsStr = http_build_query($qs);
            for ($i = 1; $i <= ($last_page ?? 1); $i++): ?>
            <li class="page-item <?= $i === ($page ?? 1) ? 'active' : '' ?>">
                <a class="page-link" href="?page=<?= $i ?>&<?= e($qsStr) ?>"><?= $i ?></a>
            </li>
            <?php endfor; ?>
        </ul>
    </div>
    <?php endif; ?>
</div>
