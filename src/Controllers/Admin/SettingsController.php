<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{AdminUser, SiteSetting};

class SettingsController
{
    public function index(Request $req, array $params = []): void
    {
        $settings = SiteSetting::allKeyed();
        View::render('admin/settings/index', compact('settings'), 'admin');
    }

    public function save(Request $req, array $params = []): void
    {
        $allowed = [
            'site_name', 'site_tagline', 'site_email', 'site_phone', 'site_address',
            'social_linkedin', 'social_instagram', 'social_facebook', 'social_youtube',
            'mail_from', 'mail_from_name', 'mail_smtp_host', 'mail_smtp_port',
            'mail_smtp_user', 'mail_smtp_pass',
            'recaptcha_site', 'recaptcha_secret',
            'ga_id', 'fb_pixel',
            'footer_text', 'footer_copyright',
        ];
        $data = [];
        foreach ($allowed as $key) {
            $val = $req->post($key);
            if ($val !== null) $data[$key] = trim((string)$val);
        }
        SiteSetting::setMany($data);
        Session::flash('success', 'Ayarlar kaydedildi.');
        View::redirect('/admin/settings');
    }

    public function users(Request $req, array $params = []): void
    {
        $users = AdminUser::all();
        View::render('admin/settings/users', compact('users'), 'admin');
    }

    public function createUser(Request $req, array $params = []): void
    {
        $name  = trim($req->post('name', ''));
        $email = trim($req->post('email', ''));
        $pass  = $req->post('password', '');
        $role  = $req->post('role', 'editor');

        if (!$name || !$email || !$pass) {
            Session::flash('error', 'Tüm alanlar zorunludur.');
            View::redirect('/admin/settings/users');
        }

        AdminUser::create(['name' => $name, 'email' => $email, 'password' => $pass, 'role' => $role, 'status' => 'active']);
        Session::flash('success', 'Kullanıcı oluşturuldu.');
        View::redirect('/admin/settings/users');
    }

    public function deleteUser(Request $req, array $params = []): void
    {
        $id = (int)$params['id'];
        if ($id !== Session::get('admin_id')) {
            AdminUser::delete($id);
            Session::flash('success', 'Kullanıcı silindi.');
        }
        View::redirect('/admin/settings/users');
    }
}
