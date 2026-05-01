<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Core\{Request, Session, View};

class MemberAuthMiddleware
{
    public function handle(Request $req): void
    {
        if (!Session::has('member_id')) {
            View::redirect('/uye/giris');
        }
    }
}
