<?php
declare(strict_types=1);

namespace App\Models;

use App\Core\DB;

class MediaFile extends BaseModel
{
    protected static string $table = 'media_files';

    public static function upload(array $file, string $folder = 'images'): array|false
    {
        $allowed = ['jpg', 'jpeg', 'png', 'webp', 'gif', 'svg', 'pdf'];
        $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));

        if (!in_array($ext, $allowed)) return false;
        if ($file['size'] > 10 * 1024 * 1024) return false;

        $filename = uniqid() . '_' . time() . '.' . $ext;
        $destDir  = UPLOAD_PATH . '/' . $folder . '/';
        $destPath = $destDir . $filename;

        if (!is_dir($destDir)) mkdir($destDir, 0755, true);
        if (!move_uploaded_file($file['tmp_name'], $destPath)) return false;

        $publicUrl = '/uploads/' . $folder . '/' . $filename;
        $id = self::create([
            'filename'  => $filename,
            'original'  => $file['name'],
            'path'      => $publicUrl,
            'type'      => $file['type'],
            'size'      => $file['size'],
            'folder'    => $folder,
            'uploaded_by' => $_SESSION['admin_id'] ?? 0,
        ]);

        return ['id' => $id, 'url' => $publicUrl, 'filename' => $filename];
    }

    public static function deleteFile(int $id): bool
    {
        $file = self::find($id);
        if (!$file) return false;

        $absPath = UPLOAD_PATH . '/' . $file['folder'] . '/' . $file['filename'];
        if (file_exists($absPath)) unlink($absPath);

        self::delete($id);
        return true;
    }
}
