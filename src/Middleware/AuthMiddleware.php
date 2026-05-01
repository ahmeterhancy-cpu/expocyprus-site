<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\{Request, Session, View};

class AuthMiddleware
{
    public function handle(Request $req): void
    {
        if (!Session::has('admin_id')) {
            View::redirect('/admin/login');
        }
    }
}
