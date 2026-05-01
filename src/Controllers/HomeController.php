<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\{Service, Fair, BlogPost, CatalogItem};

class HomeController
{
    public function index(Request $req, array $params = []): void
    {
        try { $services = Service::allActive(); }   catch (\Throwable $e) { $services = []; }
        try { $fairs    = Fair::allActive(); }      catch (\Throwable $e) { $fairs    = []; }
        try { $posts    = BlogPost::published(lang(), 3); } catch (\Throwable $e) { $posts = []; }
        try { $catalog  = CatalogItem::filtered([], 1, 6); } catch (\Throwable $e) { $catalog = ['data' => []]; }

        View::render('home', compact('services', 'fairs', 'posts', 'catalog'), 'main');
    }
}
