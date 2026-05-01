<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View, DB};
use App\Models\Order;

class OrdersController
{
    public function index(Request $req, array $params = []): void
    {
        $orders = Order::recent(100);
        View::render('admin/orders/index', compact('orders'), 'admin');
    }

    public function view(Request $req, array $params = []): void
    {
        $order = Order::find((int)$params['id']);
        if (!$order) View::redirect('/admin/orders');
        $items = json_decode($order['items_json'] ?? '[]', true) ?: [];
        View::render('admin/orders/view', compact('order', 'items'), 'admin');
    }

    public function updateStatus(Request $req, array $params = []): void
    {
        $allowed = ['pending','awaiting_transfer','paid','processing','completed','cancelled'];
        $status  = $req->post('status', '');
        if (in_array($status, $allowed, true)) {
            DB::execute("UPDATE orders SET status = ? WHERE id = ?", [$status, (int)$params['id']]);
            Session::flash('success', 'Sipariş durumu güncellendi.');
        }
        View::redirect('/admin/orders/' . (int)$params['id']);
    }

    public function destroy(Request $req, array $params = []): void
    {
        Order::delete((int)$params['id']);
        Session::flash('success', 'Sipariş silindi.');
        View::redirect('/admin/orders');
    }
}
