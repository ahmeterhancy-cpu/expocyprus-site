<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, BlockRenderer, BlockSeeder};
use App\Models\CmsPage;

class CmsBuilderController
{
    public function builder(Request $req, array $params = []): void
    {
        CmsPage::ensureTable();
        $key = $params['key'] ?? '';
        $page = CmsPage::findByKey($key);
        if (!$page) {
            Session::flash('error', 'Sayfa bulunamadı.');
            View::redirect('/admin/cms');
        }
        $blockTypes = BlockRenderer::BLOCK_TYPES;

        // Mevcut blocks'u sections_json'dan oku (geriye dönük uyumlu)
        $blocks = [];
        $isSeeded = false;
        if (!empty($page['sections_json'])) {
            $dec = json_decode((string)$page['sections_json'], true);
            if (is_array($dec)) $blocks = $dec;
        }

        // Boş ise: mevcut sayfa içeriklerinden otomatik blocklar üret
        if (empty($blocks)) {
            $blocks = BlockSeeder::defaultsFor($key);
            $isSeeded = true;
        }

        View::render('admin/cms/builder', compact('page', 'blocks', 'blockTypes', 'isSeeded'), 'admin');
    }

    public function save(Request $req, array $params = []): void
    {
        CmsPage::ensureTable();
        $key = $params['key'] ?? '';
        $page = CmsPage::findByKey($key);
        if (!$page) { View::json(['ok' => false, 'error' => 'Sayfa bulunamadı'], 404); return; }

        $blocksRaw = (string)$req->post('blocks_json', '[]');
        $decoded = json_decode($blocksRaw, true);
        if (!is_array($decoded)) {
            View::json(['ok' => false, 'error' => 'Geçersiz JSON'], 400);
            return;
        }
        // Sanitize: keep only known block types
        $known = array_keys(BlockRenderer::BLOCK_TYPES);
        $clean = [];
        foreach ($decoded as $b) {
            $t = $b['type'] ?? null;
            if (!in_array($t, $known, true)) continue;
            $clean[] = ['type' => $t, 'data' => is_array($b['data'] ?? null) ? $b['data'] : []];
        }

        CmsPage::update((int)$page['id'], [
            'sections_json' => json_encode($clean, JSON_UNESCAPED_UNICODE),
        ]);

        View::json(['ok' => true, 'count' => count($clean)]);
    }

    /** Live preview HTML — render single block (called via AJAX from builder) */
    public function previewBlock(Request $req, array $params = []): void
    {
        $type = (string)$req->post('type', '');
        $data = (array)$req->post('data', []);
        $html = BlockRenderer::renderOne(['type' => $type, 'data' => $data]);
        View::json(['ok' => true, 'html' => $html]);
    }
}
