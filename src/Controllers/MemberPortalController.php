<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Core\{Request, Session, View, DB};
use App\Models\{Member, ProductionOrder};

class MemberPortalController
{
    public function dashboard(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $member = Member::find($memberId);
        $orders = ProductionOrder::forMember($memberId);

        $stats = [
            'total'        => count($orders),
            'in_progress'  => 0,
            'completed'    => 0,
            'cancelled'    => 0,
        ];
        foreach ($orders as $o) {
            if ($o['current_stage'] === 'completed')      $stats['completed']++;
            elseif ($o['current_stage'] === 'cancelled')  $stats['cancelled']++;
            else                                          $stats['in_progress']++;
        }
        $latest = array_slice($orders, 0, 5);

        View::render('member/dashboard', compact('member','orders','stats','latest'), 'member');
    }

    public function orders(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $orders = ProductionOrder::forMember($memberId);
        View::render('member/orders', compact('orders'), 'member');
    }

    public function orderDetail(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $order = ProductionOrder::find((int)$params['id']);
        if (!$order || (int)$order['member_id'] !== $memberId) {
            Session::flash('error', 'Sipariş bulunamadı.');
            View::redirect('/uye/siparisler');
        }
        $stagesLog = ProductionOrder::getStagesLog($order['id']);
        $files     = ProductionOrder::getFiles($order['id'], true); // sadece üyenin görebileceği
        $messages  = ProductionOrder::getMessages($order['id']);
        View::render('member/order-detail', compact('order','stagesLog','files','messages'), 'member');
    }

    public function sendMessage(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $orderId  = (int)$params['id'];
        $order = ProductionOrder::find($orderId);
        if (!$order || (int)$order['member_id'] !== $memberId) View::redirect('/uye/siparisler');

        $body = trim((string)$req->post('body', ''));
        if ($body !== '') {
            ProductionOrder::addMessage(
                $orderId,
                'member',
                $memberId,
                $_SESSION['member_contact'] ?? 'Üye',
                $body
            );
            Session::flash('success', 'Mesajınız gönderildi.');
        }
        View::redirect('/uye/siparis/' . $orderId);
    }

    public function profile(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $member = Member::find($memberId);
        View::render('member/profile', [
            'member'  => $member,
            'success' => Session::getFlash('profile_success'),
            'error'   => Session::getFlash('profile_error'),
        ], 'member');
    }

    public function profileUpdate(Request $req, array $params = []): void
    {
        $memberId = (int)$_SESSION['member_id'];
        $data = [
            'company_name' => trim((string)$req->post('company_name', '')),
            'contact_name' => trim((string)$req->post('contact_name', '')),
            'phone'        => trim((string)$req->post('phone', '')) ?: null,
            'tax_no'       => trim((string)$req->post('tax_no', '')) ?: null,
            'address'      => trim((string)$req->post('address', '')) ?: null,
            'city'         => trim((string)$req->post('city', '')) ?: null,
            'country'      => trim((string)$req->post('country', 'KKTC')),
            'website'      => trim((string)$req->post('website', '')) ?: null,
        ];
        $newPass  = (string)$req->post('new_password', '');
        $newPass2 = (string)$req->post('new_password_confirm', '');
        if ($newPass !== '') {
            if (strlen($newPass) < 8) {
                Session::flash('profile_error', 'Yeni şifre en az 8 karakter olmalı.');
                View::redirect('/uye/profil');
            }
            if ($newPass !== $newPass2) {
                Session::flash('profile_error', 'Yeni şifreler eşleşmiyor.');
                View::redirect('/uye/profil');
            }
            $data['password_hash'] = password_hash($newPass, PASSWORD_BCRYPT);
        }
        Member::update($memberId, $data);
        $_SESSION['member_company'] = $data['company_name'];
        $_SESSION['member_contact'] = $data['contact_name'];
        Session::flash('profile_success', 'Profil güncellendi.');
        View::redirect('/uye/profil');
    }
}
