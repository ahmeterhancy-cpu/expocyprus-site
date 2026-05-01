<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, View};
use App\Models\{Service, Fair, BlogPost, CatalogItem};

class HomeController
{
    public function index(Request $req, array $params = []): void
    {
        try {
            $services = Service::allActive();
            $fairs    = Fair::allActive();
            $posts    = BlogPost::published(lang(), 3);
            $catalog  = CatalogItem::filtered([], 1, 6);
        } catch (\Throwable $e) {
            $services = $fairs = $posts = [];
            $catalog  = ['data' => []];
        }

        View::render('home', compact('services', 'fairs', 'posts', 'catalog'), 'main');
    }
}
