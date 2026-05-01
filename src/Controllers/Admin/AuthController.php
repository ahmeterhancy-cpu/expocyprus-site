<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\AdminUser;

class AuthController
{
    public function loginForm(Request $req, array $params = []): void
    {
        if (Session::has('admin_id')) {
            View::redirect('/admin');
        }
        View::render('admin/auth/login', [
            'error' => Session::getFlash('login_error'),
            'email' => Session::getFlash('login_email'),
        ], 'blank');
    }

    public function login(Request $req, array $params = []): void
    {
        $email    = trim($req->post('email', ''));
        $password = $req->post('password', '');

        if (empty($email) || empty($password)) {
            Session::flash('login_error', 'E-posta ve şifre zorunludur.');
            Session::flash('login_email', $email);
            View::redirect('/admin/login');
        }

        $user = AdminUser::authenticate($email, $password);
        if (!$user) {
            Session::flash('login_error', 'E-posta veya şifre hatalı.');
            Session::flash('login_email', $email);
            View::redirect('/admin/login');
        }

        Session::set('admin_id', $user['id']);
        Session::set('admin_user', $user);
        View::redirect('/admin');
    }

    public function logout(Request $req, array $params = []): void
    {
        Session::destroy();
        View::redirect('/admin/login');
    }
}
