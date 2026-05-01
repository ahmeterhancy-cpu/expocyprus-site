<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{DB, Request, View};
use App\Models\{FormSubmission, Service, Fair, BlogPost, CatalogItem, Page, MediaFile};

class DashboardController
{
    public function index(Request $req, array $params = []): void
    {
        $stats = [
            'pages'         => Page::count(),
            'services'      => Service::count(),
            'fairs'         => Fair::count(),
            'catalog'       => CatalogItem::count(),
            'blog'          => BlogPost::count(),
            'submissions'   => FormSubmission::count(),
            'submissions_today' => FormSubmission::todayCount(),
            'unread'        => FormSubmission::unreadCount(),
            'media'         => MediaFile::count(),
        ];

        $recentSubmissions = FormSubmission::recentByType('', 8);

        // Monthly submission counts (last 6 months)
        $monthlyData = DB::query("
            SELECT DATE_FORMAT(created_at, '%Y-%m') as month,
                   COUNT(*) as total
            FROM form_submissions
            WHERE created_at >= DATE_SUB(NOW(), INTERVAL 6 MONTH)
            GROUP BY month
            ORDER BY month ASC
        ");

        View::render('admin/dashboard', compact('stats', 'recentSubmissions', 'monthlyData'), 'admin');
    }
}
