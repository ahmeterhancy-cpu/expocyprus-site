<?php
/**
 * Expo Cyprus — Web tabanlı kurulum sayfası
 * Sadece ilk kurulum için — bittikten sonra sayfayı SİL.
 *
 * Yapacakları:
 *  1. .env'yi kontrol et (DB bilgileri doğru mu?)
 *  2. DB tablolarını oluştur (migrate.php)
 *  3. public/ → public_html/ kopyala (kendisi hariç)
 *  4. Storage izinlerini ayarla
 *  5. Test admin user oluştur (form üzerinden)
 *  6. Self-delete (güvenlik için)
 */
declare(strict_types=1);

// ═══ Configuration ═══
// Otomatik detect: install.php /home/USER/public_html/public/install.php konumunda
// BASE_PATH = source root (/home/USER/public_html)
// PUB_PATH  = web root  (/home/USER/public_html) — aynı dizin (single-dir layout)
$BASE_PATH = realpath(dirname(__DIR__));   // public/'in parent'ı
$PUB_PATH  = $BASE_PATH;                    // aynı (single-dir cPanel deployment)

// ═══ Helpers ═══
function out(string $msg, string $type = 'info'): void {
    $colors = ['ok' => '#10b981', 'err' => '#ef4444', 'warn' => '#f59e0b', 'info' => '#6b7280'];
    $icons  = ['ok' => '✓', 'err' => '✗', 'warn' => '⚠', 'info' => '→'];
    $color = $colors[$type] ?? $colors['info'];
    $icon  = $icons[$type] ?? $icons['info'];
    echo "<div style='padding:.5rem .75rem;margin:.25rem 0;background:#f5f5f7;border-left:3px solid $color;border-radius:6px;font-family:ui-monospace,monospace;font-size:.875rem'><span style='color:$color;font-weight:700'>$icon</span> " . htmlspecialchars($msg) . "</div>";
    @ob_flush(); @flush();
}

// HTML head
?><!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Expo Cyprus — Kurulum</title>
<style>
body { font-family: -apple-system,BlinkMacSystemFont,sans-serif; max-width: 900px; margin: 2rem auto; padding: 1.5rem; color: #1d1d1f; background: #fafafa; }
h1 { font-size: 1.75rem; margin: 0 0 .25rem; }
h2 { font-size: 1.125rem; margin: 1.5rem 0 .5rem; padding-bottom: .5rem; border-bottom: 1px solid #e5e7eb; }
.lead { color: #6b7280; margin: 0 0 1.5rem; }
.btn { display: inline-block; padding: .65rem 1.25rem; background: #E30613; color: #fff; text-decoration: none; border-radius: 8px; font-weight: 600; margin: .5rem .25rem 0 0; border: 0; cursor: pointer; font-size: .9375rem; }
.btn:hover { background: #c00510; }
.btn-secondary { background: #1d1d1f; }
.btn-danger { background: #ef4444; }
.input { display: block; width: 100%; padding: .55rem .75rem; border: 1px solid #d1d5db; border-radius: 8px; font-size: .9375rem; margin-top: .25rem; }
.field { margin-bottom: .85rem; }
label { font-size: .8125rem; font-weight: 600; color: #4b5563; }
.warn-box { background: #fef3c7; border-left: 4px solid #f59e0b; padding: 1rem; border-radius: 8px; margin: 1rem 0; }
</style>
</head>
<body>

<h1>🚀 Expo Cyprus — Kurulum</h1>
<p class="lead">Bu sayfa kurulumu yapar. Bittikten sonra <strong>kesinlikle silinmesi</strong> şart.</p>

<?php
$step = $_GET['step'] ?? 'check';
$secretToken = trim((string)($_REQUEST['token'] ?? ''));

// ═══ Token Check (basit güvenlik) ═══
$installToken = file_exists($BASE_PATH . '/.install-token')
    ? trim(file_get_contents($BASE_PATH . '/.install-token'))
    : '';

if ($installToken === '') {
    // Token yoksa oluştur (ilk açılış)
    $installToken = bin2hex(random_bytes(8));
    @file_put_contents($BASE_PATH . '/.install-token', $installToken);
    @chmod($BASE_PATH . '/.install-token', 0600);
    echo "<div class='warn-box'>";
    echo "<h2 style='margin-top:0;border:0'>⚠ Güvenlik Token'ı oluşturuldu</h2>";
    echo "<p>Kurulum tek-kullanımlık token ile korunur. Token:</p>";
    echo "<p style='font-family:monospace;background:#fff;padding:.75rem;border-radius:6px;font-size:1.1rem;letter-spacing:.05em'><strong>$installToken</strong></p>";
    echo "<p>Bu URL ile devam et:</p>";
    echo "<p><a class='btn' href='?step=check&token=$installToken'>Kuruluma Başla →</a></p>";
    echo "</div>";
    echo "</body></html>";
    exit;
}

if ($secretToken !== $installToken) {
    echo "<div class='warn-box'>";
    echo "<p><strong>Token gerekli:</strong> URL'e <code>?token=...</code> ekle.</p>";
    echo "<p>Token <code>$BASE_PATH/.install-token</code> dosyasında.</p>";
    echo "</div></body></html>";
    exit;
}

echo "<form method='post' action='?step=$step&token=$secretToken' style='margin:0'>";

// ═══ STEP: CHECK ═══
if ($step === 'check') {
    echo "<h2>① Sistem Kontrolü</h2>";

    // PHP version
    $php = PHP_VERSION;
    $phpOk = version_compare($php, '8.1.0', '>=');
    out("PHP versiyonu: $php " . ($phpOk ? '(✓ 8.1+)' : '(✗ 8.1+ gerekli)'), $phpOk ? 'ok' : 'err');

    // Required extensions
    $exts = ['pdo', 'pdo_mysql', 'mbstring', 'json', 'fileinfo', 'openssl'];
    foreach ($exts as $ext) {
        out("Extension: $ext " . (extension_loaded($ext) ? '✓' : '✗'), extension_loaded($ext) ? 'ok' : 'err');
    }

    // Paths
    out("BASE_PATH: $BASE_PATH " . (is_dir($BASE_PATH) ? '✓' : '✗'), is_dir($BASE_PATH) ? 'ok' : 'err');
    out("PUB_PATH:  $PUB_PATH " . (is_dir($PUB_PATH) ? '✓' : '✗'), is_dir($PUB_PATH) ? 'ok' : 'err');

    // .env
    $envPath = $BASE_PATH . '/.env';
    if (file_exists($envPath)) {
        out(".env mevcut: $envPath", 'ok');
        $envContent = file_get_contents($envPath);
        if (str_contains($envContent, 'DB_PASS=BURAYA') || str_contains($envContent, '__SET_DATABASE_PASSWORD__')) {
            out(".env DB_PASS henüz doldurulmamış!", 'err');
        }
    } else {
        out(".env bulunamadı: $envPath — Önce File Manager'dan oluştur", 'err');
    }

    // vendor/
    if (file_exists($BASE_PATH . '/vendor/autoload.php')) {
        out("vendor/autoload.php ✓", 'ok');
    } else {
        out("vendor/ yok — git pull yapılmamış olabilir", 'err');
    }

    // exec / shell_exec
    $execOk = function_exists('exec') && !in_array('exec', explode(',', ini_get('disable_functions') ?? ''));
    out("exec() çalışıyor: " . ($execOk ? 'evet' : 'hayır (sadece dosya işlemleri çalışacak)'), $execOk ? 'ok' : 'warn');

    echo "<a class='btn' href='?step=copy&token=$secretToken'>İleri: Public dosyaları kopyala →</a>";
}

// ═══ STEP: COPY public/ → public_html/ ═══
elseif ($step === 'copy') {
    echo "<h2>② Public Dosyaları Kopyala</h2>";

    if (!is_dir($BASE_PATH . '/public')) {
        out("Kaynak public/ bulunamadı: $BASE_PATH/public", 'err');
        echo "</form></body></html>"; exit;
    }

    $copied = 0; $skipped = 0; $failed = 0;
    $iterator = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($BASE_PATH . '/public', RecursiveDirectoryIterator::SKIP_DOTS),
        RecursiveIteratorIterator::SELF_FIRST
    );
    foreach ($iterator as $item) {
        $rel = substr($item->getPathname(), strlen($BASE_PATH . '/public/'));
        $rel = str_replace('\\', '/', $rel);

        // install.php'yi (kendini) atla
        if ($rel === 'install.php') { $skipped++; continue; }

        $dest = $PUB_PATH . '/' . $rel;
        if ($item->isDir()) {
            if (!is_dir($dest)) @mkdir($dest, 0755, true);
        } else {
            $destDir = dirname($dest);
            if (!is_dir($destDir)) @mkdir($destDir, 0755, true);
            if (@copy($item->getPathname(), $dest)) {
                $copied++;
            } else {
                $failed++;
                out("Kopyalama hatası: $rel", 'err');
            }
        }
    }

    out("Kopyalanan: $copied dosya", 'ok');
    if ($skipped) out("Atlanan: $skipped (install.php hariç)", 'info');
    if ($failed)  out("Başarısız: $failed", 'err');

    // Set permissions
    @chmod($PUB_PATH . '/uploads', 0775);
    foreach (['blog','cms','leads','orders','crew','catalog','quote-attachments','images','docs'] as $sub) {
        @chmod($PUB_PATH . "/uploads/$sub", 0775);
    }
    out("uploads/ izinleri 775 ayarlandı", 'ok');

    echo "<a class='btn' href='?step=storage&token=$secretToken'>İleri: Storage izinleri →</a>";
}

// ═══ STEP: STORAGE ═══
elseif ($step === 'storage') {
    echo "<h2>③ Storage İzinleri</h2>";
    foreach (['sessions','cache','logs'] as $dir) {
        $path = $BASE_PATH . '/storage/' . $dir;
        if (!is_dir($path)) @mkdir($path, 0775, true);
        @chmod($path, 0775);
        out("storage/$dir/ ✓ (775)", 'ok');
    }
    echo "<a class='btn' href='?step=migrate&token=$secretToken'>İleri: Veritabanı tablolarını oluştur →</a>";
}

// ═══ STEP: MIGRATE ═══
elseif ($step === 'migrate') {
    echo "<h2>④ Veritabanı Migration</h2>";

    // Load .env
    $envFile = $BASE_PATH . '/.env';
    if (!file_exists($envFile)) {
        out(".env yok!", 'err');
        echo "</form></body></html>"; exit;
    }
    foreach (file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
        if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
        [$k, $v] = explode('=', $line, 2);
        $_ENV[trim($k)] = trim($v, " \t\n\r\0\x0B\"'");
        putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
    }

    // Test DB connection
    try {
        $pdo = new PDO(
            sprintf('mysql:host=%s;port=%s;dbname=%s;charset=utf8mb4',
                getenv('DB_HOST') ?: 'localhost',
                getenv('DB_PORT') ?: '3306',
                getenv('DB_NAME')),
            getenv('DB_USER'),
            getenv('DB_PASS'),
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        out("DB bağlantısı ✓ (" . (getenv('DB_NAME')) . ")", 'ok');
    } catch (\Throwable $e) {
        out("DB bağlantı hatası: " . $e->getMessage(), 'err');
        out("\.env'deki DB_NAME, DB_USER, DB_PASS doğru mu?", 'warn');
        echo "</form></body></html>"; exit;
    }

    // Run migrate.php
    define('BASE_PATH', $BASE_PATH);
    require_once $BASE_PATH . '/vendor/autoload.php';

    try {
        \App\Core\DB::connect();

        // Schema
        $schemaFile = $BASE_PATH . '/database/schema.sql';
        if (file_exists($schemaFile)) {
            $sql = file_get_contents($schemaFile);
            foreach (array_filter(array_map('trim', explode(';', $sql))) as $stmt) {
                if ($stmt === '') continue;
                try { \App\Core\DB::execute($stmt); } catch (\Throwable $e) {
                    if (!str_contains($e->getMessage(), 'already exists')) {
                        out("Schema uyarı: " . substr($e->getMessage(), 0, 80), 'warn');
                    }
                }
            }
            out("Base schema uygulandı", 'ok');
        }

        // Models
        $models = ['CmsPage','CatalogCategory','Lead','CrewApplication','Member','ProductionOrder'];
        foreach ($models as $m) {
            $fqcn = "App\\Models\\$m";
            if (!class_exists($fqcn)) continue;
            try {
                if (method_exists($fqcn, 'ensureTable'))    $fqcn::ensureTable();
                if (method_exists($fqcn, 'ensureTables'))   $fqcn::ensureTables();
                out("$m migrasyonu ✓", 'ok');
            } catch (\Throwable $e) {
                out("$m: " . $e->getMessage(), 'warn');
            }
        }
        foreach (['Service','Fair'] as $m) {
            $fqcn = "App\\Models\\$m";
            if (class_exists($fqcn) && method_exists($fqcn, 'ensureExtended')) {
                try { $fqcn::ensureExtended(); out("$m extended ✓", 'ok'); } catch (\Throwable $e) {}
            }
        }

        out("✓ Migration tamamlandı", 'ok');
    } catch (\Throwable $e) {
        out("Migration hatası: " . $e->getMessage(), 'err');
    }

    echo "<a class='btn' href='?step=admin&token=$secretToken'>İleri: Admin kullanıcı oluştur →</a>";
}

// ═══ STEP: ADMIN ═══
elseif ($step === 'admin') {
    echo "<h2>⑤ Admin Kullanıcı Oluştur</h2>";

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $name  = trim($_POST['name']  ?? 'Admin');
        $email = trim($_POST['email'] ?? '');
        $pass  = (string)($_POST['password'] ?? '');

        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($pass) < 8) {
            out("E-posta geçerli değil veya şifre 8 karakterden kısa", 'err');
        } else {
            // Load env + connect
            foreach (file($BASE_PATH . '/.env', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES) as $line) {
                if (str_starts_with(trim($line), '#') || !str_contains($line, '=')) continue;
                [$k, $v] = explode('=', $line, 2);
                putenv(trim($k) . '=' . trim($v, " \t\n\r\0\x0B\"'"));
            }
            try {
                $pdo = new PDO(
                    sprintf('mysql:host=%s;dbname=%s;charset=utf8mb4',
                        getenv('DB_HOST'), getenv('DB_NAME')),
                    getenv('DB_USER'), getenv('DB_PASS'),
                    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
                );
                $hash = password_hash($pass, PASSWORD_BCRYPT);
                $stmt = $pdo->prepare("INSERT INTO admin_users (name, email, password_hash, role, status, created_at, updated_at) VALUES (?, ?, ?, 'super_admin', 'active', NOW(), NOW())");
                $stmt->execute([$name, $email, $hash]);
                out("Admin kullanıcı oluşturuldu: $email", 'ok');
                echo "<a class='btn' href='?step=done&token=$secretToken'>İleri: Bitir + Sayfayı sil →</a>";
                echo "</form></body></html>"; exit;
            } catch (\Throwable $e) {
                if (str_contains($e->getMessage(), 'Duplicate')) {
                    out("Bu e-posta zaten kayıtlı.", 'warn');
                    echo "<a class='btn' href='?step=done&token=$secretToken'>İleri: Bitir →</a>";
                    echo "</form></body></html>"; exit;
                }
                out("Hata: " . $e->getMessage(), 'err');
            }
        }
    }
    ?>
    <p>Admin paneline giriş için bir hesap oluşturun:</p>
    <div class="field">
        <label>Ad</label>
        <input class="input" name="name" value="Admin" required>
    </div>
    <div class="field">
        <label>E-posta</label>
        <input class="input" name="email" type="email" placeholder="admin@expocyprus.com" required>
    </div>
    <div class="field">
        <label>Şifre (min 8 karakter)</label>
        <input class="input" name="password" type="password" required minlength="8">
    </div>
    <button class="btn" type="submit">Admin Hesabı Oluştur</button>
    <?php
}

// ═══ STEP: DONE ═══
elseif ($step === 'done') {
    echo "<h2>⑥ Tamamlandı 🎉</h2>";

    // Self-delete
    $thisFile = __FILE__;
    $tokenFile = $BASE_PATH . '/.install-token';
    if (@unlink($thisFile)) {
        out("install.php silindi (güvenlik için)", 'ok');
    } else {
        out("install.php silinemedi — manuel sil: $thisFile", 'warn');
    }
    if (file_exists($tokenFile)) @unlink($tokenFile);

    echo "<div class='warn-box' style='background:#d1fae5;border-color:#10b981'>";
    echo "<h2 style='margin-top:0;border:0;color:#065f46'>✅ Site canlıda</h2>";
    echo "<p><strong>Public site:</strong> <a href='https://expocyprus.com' target='_blank'>https://expocyprus.com</a></p>";
    echo "<p><strong>Admin paneli:</strong> <a href='https://expocyprus.com/admin/login' target='_blank'>https://expocyprus.com/admin/login</a></p>";
    echo "<p><strong>Yapılacaklar:</strong></p>";
    echo "<ul>";
    echo "<li>Admin paneline gir → Site Ayarları'nı doldur (logo, telefon, sosyal medya)</li>";
    echo "<li>Sayfa Düzenleyici'yi kullan</li>";
    echo "<li>Büyük asset görsellerini cPanel File Manager ile public_html/assets/images/ altına yükle</li>";
    echo "</ul>";
    echo "</div>";
}
?>

</form>
</body>
</html>
