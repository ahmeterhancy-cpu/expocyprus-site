<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, Session, View};
use App\Models\Member;

class MemberAuthController
{
    public function loginForm(Request $req, array $params = []): void
    {
        if (Session::has('member_id')) View::redirect('/uye/panel');
        View::render('member/login', [
            'success' => Session::getFlash('member_login_success'),
            'error'   => Session::getFlash('member_login_error'),
            'old'     => Session::getFlash('member_login_old') ?? [],
        ], 'auth');
    }

    public function login(Request $req, array $params = []): void
    {
        $email    = trim((string)$req->post('email', ''));
        $password = (string)$req->post('password', '');

        if ($email === '' || $password === '') {
            Session::flash('member_login_error', 'E-posta ve şifre zorunlu.');
            Session::flash('member_login_old', ['email' => $email]);
            View::redirect('/uye/giris');
        }

        $member = Member::authenticate($email, $password);
        if (!$member) {
            Session::flash('member_login_error', 'E-posta veya şifre hatalı, ya da hesabınız henüz onaylanmadı.');
            Session::flash('member_login_old', ['email' => $email]);
            View::redirect('/uye/giris');
        }

        // Update last login
        Member::update($member['id'], [
            'last_login_at' => date('Y-m-d H:i:s'),
            'last_login_ip' => $_SERVER['REMOTE_ADDR'] ?? '',
        ]);

        $_SESSION['member_id']      = (int)$member['id'];
        $_SESSION['member_email']   = $member['email'];
        $_SESSION['member_company'] = $member['company_name'];
        $_SESSION['member_contact'] = $member['contact_name'];

        Session::flash('member_dashboard_success', 'Hoş geldiniz, ' . $member['contact_name'] . '!');
        View::redirect('/uye/panel');
    }

    public function registerForm(Request $req, array $params = []): void
    {
        if (Session::has('member_id')) View::redirect('/uye/panel');
        View::render('member/register', [
            'success' => Session::getFlash('member_register_success'),
            'error'   => Session::getFlash('member_register_error'),
            'old'     => Session::getFlash('member_register_old') ?? [],
        ], 'auth');
    }

    public function register(Request $req, array $params = []): void
    {
        $data = [
            'company_name' => trim((string)$req->post('company_name', '')),
            'contact_name' => trim((string)$req->post('contact_name', '')),
            'email'        => strtolower(trim((string)$req->post('email', ''))),
            'phone'        => trim((string)$req->post('phone', '')) ?: null,
            'tax_no'       => trim((string)$req->post('tax_no', '')) ?: null,
            'address'      => trim((string)$req->post('address', '')) ?: null,
            'city'         => trim((string)$req->post('city', '')) ?: null,
            'country'      => trim((string)$req->post('country', 'KKTC')),
            'website'      => trim((string)$req->post('website', '')) ?: null,
        ];
        $password  = (string)$req->post('password', '');
        $password2 = (string)$req->post('password_confirm', '');
        $kvkk      = (bool)$req->post('kvkk_accepted', false);

        $errors = [];
        if ($data['company_name'] === '')                                         $errors[] = 'Firma adı zorunlu.';
        if ($data['contact_name'] === '')                                         $errors[] = 'Yetkili adı zorunlu.';
        if ($data['email'] === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli e-posta gerekli.';
        if (strlen($password) < 8)                                                $errors[] = 'Şifre en az 8 karakter olmalı.';
        if ($password !== $password2)                                             $errors[] = 'Şifreler eşleşmiyor.';
        if (!$kvkk)                                                               $errors[] = 'KVKK onayı zorunlu.';
        if (Member::findByEmail($data['email']))                                  $errors[] = 'Bu e-posta zaten kayıtlı.';

        if (!empty($errors)) {
            Session::flash('member_register_error', implode(' ', $errors));
            Session::flash('member_register_old', $data);
            View::redirect('/uye/kayit');
        }

        $data['password'] = $password;
        $data['status']   = 'pending'; // Admin onayı bekliyor
        Member::register($data);

        Session::flash('member_login_success', 'Kaydınız alındı! Hesabınız onay sürecindedir, en kısa sürede sizinle iletişime geçilecek.');
        View::redirect('/uye/giris');
    }

    public function logout(Request $req, array $params = []): void
    {
        unset($_SESSION['member_id'], $_SESSION['member_email'], $_SESSION['member_company'], $_SESSION['member_contact']);
        Session::flash('member_login_success', 'Güvenli bir şekilde çıkış yapıldı.');
        View::redirect('/uye/giris');
    }
}
