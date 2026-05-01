<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, View};
use App\Models\MediaFile;

class MediaController
{
    public function index(Request $req, array $params = []): void
    {
        $folder = $req->get('folder', '');
        $page   = max(1, (int)$req->get('page', 1));
        $where  = $folder ? "folder = ?" : '';
        $wParam = $folder ? [$folder] : [];
        $result = MediaFile::paginate($page, 24, $where, $wParam);

        View::render('admin/media/index', array_merge($result, compact('folder')), 'admin');
    }

    public function upload(Request $req, array $params = []): void
    {
        $file   = $req->file('file');
        $folder = $req->post('folder', 'images');

        if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
            View::json(['success' => false, 'message' => 'Dosya yükleme hatası.'], 400);
        }

        $result = MediaFile::upload($file, $folder);
        if (!$result) {
            View::json(['success' => false, 'message' => 'Desteklenmeyen dosya tipi veya boyut aşımı.'], 422);
        }

        View::json(['success' => true, 'data' => $result]);
    }

    public function destroy(Request $req, array $params = []): void
    {
        $deleted = MediaFile::deleteFile((int)$params['id']);
        if ($req->isAjax()) {
            View::json(['success' => $deleted]);
        }
        View::redirect('/admin/media');
    }
}
