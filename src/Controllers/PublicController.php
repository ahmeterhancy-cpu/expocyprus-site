<?php
declare(strict_types=1);
namespace App\Controllers;
use App\Core\{Request, Session, View};
use App\Models\{Service, Fair, BlogPost, CatalogItem, FormSubmission};

class PublicController
{
    public function about(Request $req, array $params = []): void
    {
        View::render('about', [], 'main');
    }

    public function services(Request $req, array $params = []): void
    {
        try { $services = Service::allActive(); } catch (\Throwable $e) { $services = []; }
        View::render('services', compact('services'), 'main');
    }

    public function serviceDetail(Request $req, array $params = []): void
    {
        try { $service = Service::findBySlug($params['slug']); } catch (\Throwable $e) { $service = null; }
        if (!$service || $service['status'] !== 'active') { http_response_code(404); View::render('404', [], 'main'); return; }
        View::render('service-detail', compact('service'), 'main');
    }

    public function fairs(Request $req, array $params = []): void
    {
        try { $fairs = Fair::allActive(); } catch (\Throwable $e) { $fairs = []; }
        View::render('fairs', compact('fairs'), 'main');
    }

    public function fairDetail(Request $req, array $params = []): void
    {
        try { $fair = Fair::findBySlug($params['slug']); } catch (\Throwable $e) { $fair = null; }
        if (!$fair || $fair['status'] !== 'active') { http_response_code(404); View::render('404', [], 'main'); return; }
        View::render('fair-detail', compact('fair'), 'main');
    }

    public function catalog(Request $req, array $params = []): void
    {
        $page   = max(1, (int)$req->get('page', 1));
        $filters = ['category' => $req->get('category',''), 'stand_type' => $req->get('type','')];
        try { $result = CatalogItem::filtered(array_filter($filters), $page, 12); } catch (\Throwable $e) { $result = ['data'=>[],'total'=>0,'page'=>1,'last_page'=>1]; }
        View::render('catalog', array_merge($result, compact('filters')), 'main');
    }

    public function blog(Request $req, array $params = []): void
    {
        $page = max(1, (int)$req->get('page', 1));
        try { $result = BlogPost::allPublished(lang(), $page, 9); } catch (\Throwable $e) { $result = ['data'=>[],'total'=>0,'page'=>1,'last_page'=>1]; }
        View::render('blog', $result, 'main');
    }

    public function blogDetail(Request $req, array $params = []): void
    {
        try { $post = BlogPost::findBySlug($params['slug'], lang()); } catch (\Throwable $e) { $post = null; }
        if (!$post || $post['status'] !== 'published') { http_response_code(404); View::render('404', [], 'main'); return; }
        View::render('blog-detail', compact('post'), 'main');
    }

    public function contact(Request $req, array $params = []): void
    {
        View::render('contact', ['success' => Session::getFlash('contact_success'), 'error' => Session::getFlash('contact_error')], 'main');
    }

    public function contactPost(Request $req, array $params = []): void
    {
        $data = ['name' => trim($req->post('name','')), 'email' => trim($req->post('email','')), 'phone' => trim($req->post('phone','')), 'subject' => trim($req->post('subject','')), 'message' => trim($req->post('message',''))];
        if (empty($data['name']) || empty($data['email']) || empty($data['message'])) {
            Session::flash('contact_error', 'Lütfen zorunlu alanları doldurun.');
            View::redirect(url('iletisim'));
        }
        try {
            FormSubmission::create(['form_type'=>'contact','data_json'=>json_encode($data,JSON_UNESCAPED_UNICODE),'source_page'=>'/iletisim','ip'=>$_SERVER['REMOTE_ADDR']??'','user_agent'=>$_SERVER['HTTP_USER_AGENT']??'']);
            Session::flash('contact_success', 'Mesajınız alındı. En kısa sürede dönüş yapacağız.');
        } catch (\Throwable $e) { Session::flash('contact_error', 'Bir hata oluştu. Lütfen tekrar deneyin.'); }
        View::redirect(url('iletisim'));
    }

    public function quote(Request $req, array $params = []): void
    {
        View::render('quote', [
            'success'  => Session::getFlash('quote_success'),
            'error'    => Session::getFlash('quote_error'),
            'oldInput' => Session::getFlash('quote_old') ?? [],
        ], 'main');
    }

    public function quotePost(Request $req, array $params = []): void
    {
        // ── 1) Fuar Bilgileri ────────────────────────────────────────────
        $fair = [
            'fair_name'     => trim($req->post('fair_name', '')),
            'fair_location' => trim($req->post('fair_location', '')),
            'fair_date'     => trim($req->post('fair_date', '')),
        ];

        // ── 2) Firma Bilgileri ───────────────────────────────────────────
        $company = [
            'company'      => trim($req->post('company', '')),
            'contact_name' => trim($req->post('contact_name', '')),
            'email'        => trim($req->post('email', '')),
            'phone'        => trim($req->post('phone', '')),
            'website'      => trim($req->post('website', '')),
        ];

        // ── 3) Stand Tipi ve Boyut ───────────────────────────────────────
        $stand = [
            'stand_type'    => trim($req->post('stand_type', '')),       // 4-cephe, 3-cephe, L, tek-cephe
            'stand_system'  => trim($req->post('stand_system', '')),     // ahsap, maxima, moduler, truss
            'length_m'      => (float)$req->post('length_m', 0),
            'width_m'       => (float)$req->post('width_m', 0),
            'height_cm'     => (int)$req->post('height_cm', 0),
            'total_sqm'     => (float)$req->post('total_sqm', 0),
            'structure'     => trim($req->post('structure', 'tek-katli')),
            'floor_type'    => trim($req->post('floor_type', '')),
        ];

        // ── 4) Özellikler (çoklu seçim) ──────────────────────────────────
        $features = [
            'extra_sections' => array_values((array)$req->post('extra_sections', [])),
            'display_type'   => array_values((array)$req->post('display_type', [])),
            'lighting_color' => trim($req->post('lighting_color', '')),
            'logo_type'      => trim($req->post('logo_type', '')),
            'shelf_lighting' => trim($req->post('shelf_lighting', '')),
            'shelf_position' => trim($req->post('shelf_position', '')),
        ];

        // ── 5) Adet Girişleri ────────────────────────────────────────────
        $tvSizes = ['32', '43', '50', '55', '65', '75', '86'];
        $tvBreakdown = [];
        foreach ($tvSizes as $sz) {
            $qty = (int)$req->post('q_led_tv_' . $sz, 0);
            if ($qty > 0) $tvBreakdown[$sz . '"'] = $qty;
        }

        $quantities = [
            'tables_round'       => (int)$req->post('q_tables', 0),
            'tables_square'      => (int)$req->post('q_tables_2', 0),
            'reception'          => (int)$req->post('q_reception', 0),
            'led_tv'             => (int)$req->post('q_led_tv', 0),
            'led_tv_sizes'       => $tvBreakdown, // {"55\"": 2, "75\"": 1}
            'led_screen'         => (int)$req->post('q_led_screen', 0),
            'led_screen_length'  => (float)$req->post('led_screen_length', 0),
            'led_screen_width'   => (float)$req->post('led_screen_width', 0),
            'led_screen_pitch'   => trim($req->post('led_screen_pitch', '')),
            'vip_chair'          => (int)$req->post('q_vip_chair', 0),
            'chair_white'        => (int)$req->post('q_chair', 0),
            'chair_black'        => (int)$req->post('q_chair_2', 0),
            'sofa_group'         => (int)$req->post('q_sofa_group', 0),
            'bar_stool'          => (int)$req->post('q_bar_stool', 0),
            'brochure_rack'      => (int)$req->post('q_brochure_rack', 0),
            'hostess'            => trim($req->post('hostess', 'hayir')),
            'hostess_male'       => (int)$req->post('hostess_male', 0),
            'hostess_female'     => (int)$req->post('hostess_female', 0),
        ];

        // ── 6) Bütçe ve Notlar ───────────────────────────────────────────
        $extra = [
            'budget_min' => trim($req->post('budget_min', '')),
            'budget_max' => trim($req->post('budget_max', '')),
            'currency'   => trim($req->post('currency', 'EUR')),
            'notes'      => trim($req->post('notes', '')),
        ];

        // ── 6.5) Dosya Yüklemeleri (örnek proje, brif, görsel) ───────────
        $attachments = [];
        if (!empty($_FILES['attachments']) && is_array($_FILES['attachments']['name'] ?? null)) {
            $allowedExts = ['jpg','jpeg','png','webp','gif','pdf','doc','docx','zip'];
            $maxSize     = 10 * 1024 * 1024; // 10 MB
            $maxCount    = 8;
            $uploadDir   = BASE_PATH . '/public/uploads/quote-attachments';
            if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);

            $count = min(count($_FILES['attachments']['name']), $maxCount);
            for ($i = 0; $i < $count; $i++) {
                if ($_FILES['attachments']['error'][$i] !== UPLOAD_ERR_OK) continue;
                $origName = $_FILES['attachments']['name'][$i];
                $tmpName  = $_FILES['attachments']['tmp_name'][$i];
                $size     = (int)$_FILES['attachments']['size'][$i];
                $ext      = strtolower(pathinfo($origName, PATHINFO_EXTENSION));

                if (!in_array($ext, $allowedExts, true)) continue;
                if ($size <= 0 || $size > $maxSize) continue;
                if (!is_uploaded_file($tmpName)) continue;

                $safeBase = preg_replace('/[^A-Za-z0-9_\-]/', '_', pathinfo($origName, PATHINFO_FILENAME));
                $newName  = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_' . substr($safeBase, 0, 40) . '.' . $ext;
                $destPath = $uploadDir . '/' . $newName;

                if (@move_uploaded_file($tmpName, $destPath)) {
                    $attachments[] = [
                        'original' => $origName,
                        'path'     => '/uploads/quote-attachments/' . $newName,
                        'size'     => $size,
                        'mime'     => $ext,
                    ];
                }
            }
        }
        $extra['attachments'] = $attachments;

        // ── 7) KVKK ──────────────────────────────────────────────────────
        $kvkkAccepted = (bool)$req->post('kvkk_accepted', false);

        // ── Validation ───────────────────────────────────────────────────
        $errors = [];
        if (empty($company['contact_name'])) $errors[] = 'Yetkili adı zorunludur.';
        if (empty($company['email']) || !filter_var($company['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli bir e-posta gerekli.';
        if (empty($company['phone'])) $errors[] = 'Telefon zorunludur.';
        if (!$kvkkAccepted) $errors[] = 'KVKK metnini onaylamanız gerekiyor.';

        $allData = array_merge($fair, $company, $stand, $features, $quantities, $extra, ['kvkk_accepted' => $kvkkAccepted]);

        if (!empty($errors)) {
            Session::flash('quote_error', implode(' ', $errors));
            Session::flash('quote_old', $allData);
            View::redirect(url('teklif-al'));
        }

        try {
            FormSubmission::create([
                'form_type'   => 'stand_request',
                'data_json'   => json_encode($allData, JSON_UNESCAPED_UNICODE),
                'source_page' => '/teklif-al',
                'ip'          => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent'  => $_SERVER['HTTP_USER_AGENT'] ?? '',
            ]);
            Session::flash('quote_success', 'Stand talebiniz alındı. Detaylı incelemenin ardından 24 saat içinde sizi arayacağız.');
        } catch (\Throwable $e) {
            Session::flash('quote_error', 'Talep gönderilemedi. Lütfen tekrar deneyin.');
            Session::flash('quote_old', $allData);
        }
        View::redirect(url('teklif-al'));
    }

    public function hotels(\App\Core\Request $req, array $params = []): void
    {
        $region = $req->get('region', '');
        try { $hotels = \App\Models\Hotel::allActive($region); }
        catch (\Throwable $e) { $hotels = []; }
        try { $regionCounts = \App\Models\Hotel::countByRegion(); }
        catch (\Throwable $e) { $regionCounts = []; }
        \App\Core\View::render('hotels', compact('hotels', 'region', 'regionCounts'), 'main');
    }

    public function hotelDetail(\App\Core\Request $req, array $params = []): void
    {
        try { $hotel = \App\Models\Hotel::findBySlug($params['slug']); }
        catch (\Throwable $e) { $hotel = null; }
        if (!$hotel || $hotel['status'] !== 'active') {
            http_response_code(404);
            \App\Core\View::render('404', [], 'main');
            return;
        }
        \App\Core\View::render('hotel-detail', compact('hotel'), 'main');
    }

    // ─── SEPET / CART ───────────────────────────────────────────────
    public function cart(Request $req, array $params = []): void
    {
        View::render('cart', [
            'items'    => \App\Core\Cart::items(),
            'subtotal' => \App\Core\Cart::subtotal(),
            'currency' => \App\Core\Cart::currency(),
            'success'  => Session::getFlash('cart_success'),
            'error'    => Session::getFlash('cart_error'),
        ], 'main');
    }

    public function cartAdd(Request $req, array $params = []): void
    {
        $modelNo = trim($req->post('model_no', $req->get('model','')));
        $qty     = max(1, (int)$req->post('qty', 1));
        if (\App\Core\Cart::add($modelNo, $qty)) {
            Session::flash('cart_success', $modelNo . ' sepete eklendi.');
        } else {
            Session::flash('cart_error', 'Model bulunamadı.');
        }
        View::redirect(url('sepet'));
    }

    public function cartUpdate(Request $req, array $params = []): void
    {
        $items = (array)$req->post('items', []);
        foreach ($items as $modelNo => $qty) {
            \App\Core\Cart::update((string)$modelNo, (int)$qty);
        }
        Session::flash('cart_success', 'Sepet güncellendi.');
        View::redirect(url('sepet'));
    }

    public function cartRemove(Request $req, array $params = []): void
    {
        $modelNo = trim($req->post('model_no', $params['model_no'] ?? ''));
        \App\Core\Cart::remove($modelNo);
        Session::flash('cart_success', $modelNo . ' sepetten çıkarıldı.');
        View::redirect(url('sepet'));
    }

    public function cartClear(Request $req, array $params = []): void
    {
        \App\Core\Cart::clear();
        View::redirect(url('sepet'));
    }

    // ─── ÖDEME / CHECKOUT ───────────────────────────────────────────
    public function checkout(Request $req, array $params = []): void
    {
        $items = \App\Core\Cart::items();
        if (empty($items)) {
            Session::flash('cart_error', 'Sepetiniz boş. Önce model seçin.');
            View::redirect(url('stand-katalogu'));
        }
        View::render('checkout', [
            'items'    => $items,
            'subtotal' => \App\Core\Cart::subtotal(),
            'currency' => \App\Core\Cart::currency(),
            'error'    => Session::getFlash('checkout_error'),
            'old'      => Session::getFlash('checkout_old') ?? [],
        ], 'main');
    }

    public function checkoutPost(Request $req, array $params = []): void
    {
        $items    = \App\Core\Cart::items();
        $subtotal = \App\Core\Cart::subtotal();
        $currency = \App\Core\Cart::currency();

        if (empty($items)) View::redirect(url('stand-katalogu'));

        $data = [
            'customer_name'    => trim($req->post('customer_name','')),
            'customer_email'   => trim($req->post('customer_email','')),
            'customer_phone'   => trim($req->post('customer_phone','')),
            'customer_company' => trim($req->post('customer_company','')),
            'customer_address' => trim($req->post('customer_address','')),
            'fair_name'        => trim($req->post('fair_name','')),
            'fair_date'        => trim($req->post('fair_date','')) ?: null,
            'fair_location'    => trim($req->post('fair_location','')),
            'payment_method'   => $req->post('payment_method','bank_transfer'),
            'notes'            => trim($req->post('notes','')),
        ];

        $errors = [];
        if (empty($data['customer_name'])) $errors[] = 'Ad-soyad zorunlu.';
        if (empty($data['customer_email']) || !filter_var($data['customer_email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli e-posta gerekli.';
        if (empty($data['customer_phone'])) $errors[] = 'Telefon zorunlu.';
        if (!in_array($data['payment_method'], ['bank_transfer','credit_card'], true)) $data['payment_method'] = 'bank_transfer';
        if (!(bool)$req->post('kvkk', false)) $errors[] = 'KVKK onayı gerekli.';

        if (!empty($errors)) {
            Session::flash('checkout_error', implode(' ', $errors));
            Session::flash('checkout_old', $data);
            View::redirect(url('odeme'));
        }

        $orderNo = \App\Models\Order::generateOrderNo();
        $orderData = array_merge($data, [
            'order_no'      => $orderNo,
            'items_json'    => json_encode(array_values($items), JSON_UNESCAPED_UNICODE),
            'subtotal'      => $subtotal,
            'vat_rate'      => 0,
            'total'         => $subtotal,
            'currency'      => $currency,
            'payment_status'=> 'pending',
            'status'        => $data['payment_method'] === 'bank_transfer' ? 'awaiting_transfer' : 'pending',
            'ip'            => $_SERVER['REMOTE_ADDR'] ?? '',
            'user_agent'    => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
        ]);

        try {
            \App\Models\Order::create($orderData);
            \App\Core\Cart::clear();
            View::redirect(url('siparis/' . $orderNo));
        } catch (\Throwable $e) {
            Session::flash('checkout_error', 'Sipariş oluşturulamadı: ' . $e->getMessage());
            Session::flash('checkout_old', $data);
            View::redirect(url('odeme'));
        }
    }

    public function orderSuccess(Request $req, array $params = []): void
    {
        $orderNo = $params['order_no'] ?? '';
        $order = \App\Models\Order::findByOrderNo($orderNo);
        if (!$order) {
            http_response_code(404);
            View::render('404', [], 'main');
            return;
        }
        $items = json_decode($order['items_json'] ?? '[]', true) ?: [];
        View::render('order-success', compact('order', 'items'), 'main');
    }

    // ─── FİYATSIZ TALEP / INQUIRY ───────────────────────────────────
    public function inquiry(Request $req, array $params = []): void
    {
        $modelNo = trim($req->get('model', ''));
        $model = null;
        if ($modelNo) {
            try { $model = \App\Models\CatalogItem::findByModelNo($modelNo); } catch (\Throwable $e) {}
        }
        View::render('inquiry', [
            'model'   => $model,
            'success' => Session::getFlash('inquiry_success'),
            'error'   => Session::getFlash('inquiry_error'),
            'old'     => Session::getFlash('inquiry_old') ?? [],
        ], 'main');
    }

    public function inquiryPost(Request $req, array $params = []): void
    {
        $data = [
            'model_no'      => trim($req->post('model_no','')),
            'customer_name' => trim($req->post('customer_name','')),
            'company'       => trim($req->post('company','')),
            'email'         => trim($req->post('email','')),
            'phone'         => trim($req->post('phone','')),
            'fair_name'     => trim($req->post('fair_name','')),
            'fair_date'     => trim($req->post('fair_date','')),
            'message'       => trim($req->post('message','')),
        ];

        $errors = [];
        if (empty($data['customer_name'])) $errors[] = 'Ad zorunlu.';
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli e-posta.';
        if (empty($data['phone'])) $errors[] = 'Telefon zorunlu.';
        if (!(bool)$req->post('kvkk', false)) $errors[] = 'KVKK onayı.';

        if (!empty($errors)) {
            Session::flash('inquiry_error', implode(' ', $errors));
            Session::flash('inquiry_old', $data);
            View::redirect(url('talep-formu') . ($data['model_no'] ? '?model=' . urlencode($data['model_no']) : ''));
        }

        try {
            FormSubmission::create([
                'form_type'   => 'stand_inquiry',
                'data_json'   => json_encode($data, JSON_UNESCAPED_UNICODE),
                'source_page' => '/talep-formu',
                'ip'          => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent'  => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            ]);
            Session::flash('inquiry_success', 'Talebiniz alındı. Ekibimiz 24 saat içinde sizi arayacak.');
        } catch (\Throwable $e) {
            Session::flash('inquiry_error', 'Talep gönderilemedi.');
            Session::flash('inquiry_old', $data);
        }
        View::redirect(url('talep-formu') . ($data['model_no'] ? '?model=' . urlencode($data['model_no']) : ''));
    }

    /* ═══════════════════════════════════════════════════════════════
       Malzeme Talebi — Mobilya & Ekipman talep formu
    ═══════════════════════════════════════════════════════════════ */
    public function materialRequest(Request $req, array $params = []): void
    {
        View::render('material-request', [
            'success'  => Session::getFlash('material_success'),
            'error'    => Session::getFlash('material_error'),
            'oldInput' => Session::getFlash('material_old') ?? [],
        ], 'main');
    }

    public function materialRequestPost(Request $req, array $params = []): void
    {
        // Adet alanları
        $qtyKeys = [
            'q_tables', 'q_tables_2', 'q_reception',
            'q_chair', 'q_chair_2', 'q_vip_chair',
            'q_sofa_group', 'q_bar_stool', 'q_brochure_rack',
            'q_led_tv_32','q_led_tv_43','q_led_tv_50','q_led_tv_55',
            'q_led_tv_65','q_led_tv_75','q_led_tv_86','q_led_tv',
            'q_led_screen',
        ];
        $quantities = [];
        foreach ($qtyKeys as $k) {
            $v = (int)$req->post($k, 0);
            if ($v > 0) $quantities[$k] = $v;
        }

        $data = [
            'contact_name' => trim((string)$req->post('contact_name', '')),
            'company'      => trim((string)$req->post('company', '')),
            'email'        => trim((string)$req->post('email', '')),
            'phone'        => trim((string)$req->post('phone', '')),
            'event_name'   => trim((string)$req->post('event_name', '')),
            'event_date'   => trim((string)$req->post('event_date', '')),
            'event_location' => trim((string)$req->post('event_location', '')),
            'quantities'   => $quantities,
            'led_screen_length' => trim((string)$req->post('led_screen_length', '')),
            'led_screen_width'  => trim((string)$req->post('led_screen_width', '')),
            'led_screen_pitch'  => trim((string)$req->post('led_screen_pitch', '')),
            'notes'        => trim((string)$req->post('notes', '')),
        ];

        $errors = [];
        if ($data['contact_name'] === '')                                  $errors[] = 'Ad Soyad zorunlu.';
        if ($data['company']      === '')                                  $errors[] = 'Firma adı zorunlu.';
        if ($data['email']        === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli e-posta gerekli.';
        if ($data['phone']        === '')                                  $errors[] = 'Telefon zorunlu.';
        if (empty($quantities))                                            $errors[] = 'En az bir malzeme adedi giriniz.';
        if (!(bool)$req->post('kvkk_accepted', false))                     $errors[] = 'KVKK onayı gerekli.';

        if (!empty($errors)) {
            Session::flash('material_error', implode(' ', $errors));
            Session::flash('material_old', $data);
            View::redirect(url('malzeme-talebi'));
        }

        try {
            \App\Models\FormSubmission::create([
                'form_type'   => 'material_request',
                'data_json'   => json_encode($data, JSON_UNESCAPED_UNICODE),
                'source_page' => '/malzeme-talebi',
                'ip'          => $_SERVER['REMOTE_ADDR'] ?? '',
                'user_agent'  => substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500),
            ]);
            Session::flash('material_success', 'Malzeme talebiniz alındı. Ekibimiz 24 saat içinde sizi arayacak.');
        } catch (\Throwable $e) {
            Session::flash('material_error', 'Talep gönderilemedi. Lütfen tekrar deneyin.');
            Session::flash('material_old', $data);
        }
        View::redirect(url('malzeme-talebi'));
    }

    /* ═══════════════════════════════════════════════════════════════
       Unifex Crew — Başvuru Formu
    ═══════════════════════════════════════════════════════════════ */
    public function crewForm(Request $req, array $params = []): void
    {
        View::render('crew-form', [
            'success'  => Session::getFlash('crew_success'),
            'error'    => Session::getFlash('crew_error'),
            'oldInput' => Session::getFlash('crew_old') ?? [],
        ], 'main');
    }

    public function crewSubmit(Request $req, array $params = []): void
    {
        \App\Models\CrewApplication::ensureTable();

        // Çoklu pozisyon (checkbox)
        $positionsArr = (array)$req->post('positions', []);
        $positionsArr = array_values(array_filter(array_map('trim', $positionsArr)));
        $positionsCsv = implode(',', $positionsArr);

        $data = [
            // Kişisel
            'first_name'        => trim((string)$req->post('first_name', '')),
            'last_name'         => trim((string)$req->post('last_name', '')),
            'birth_date'        => trim((string)$req->post('birth_date', '')) ?: null,
            'age'               => $req->post('age', '') !== '' ? (int)$req->post('age', 0) : null,
            'gender'            => trim((string)$req->post('gender', '')),
            'marital_status'    => trim((string)$req->post('marital_status', '')) ?: null,
            'nationality'       => trim((string)$req->post('nationality', '')) ?: null,
            'id_number'         => trim((string)$req->post('id_number', '')) ?: null,

            // İletişim
            'phone'             => trim((string)$req->post('phone', '')),
            'email'             => trim((string)$req->post('email', '')),
            'instagram'         => trim((string)$req->post('instagram', '')) ?: null,
            'city'              => trim((string)$req->post('city', '')) ?: null,
            'address'           => trim((string)$req->post('address', '')) ?: null,

            // Fiziksel
            'height_cm'         => $req->post('height_cm', '') !== '' ? (int)$req->post('height_cm', 0) : null,
            'weight_kg'         => $req->post('weight_kg', '') !== '' ? (int)$req->post('weight_kg', 0) : null,
            'shirt_size'        => trim((string)$req->post('shirt_size', '')) ?: null,
            'shoe_size'         => trim((string)$req->post('shoe_size', '')) ?: null,
            'body_size'         => trim((string)$req->post('body_size', '')) ?: null,
            'hair_color'        => trim((string)$req->post('hair_color', '')) ?: null,
            'eye_color'         => trim((string)$req->post('eye_color', '')) ?: null,

            // Eğitim & Diller
            'education'         => trim((string)$req->post('education', '')) ?: null,
            'languages'         => trim((string)$req->post('languages', '')) ?: null,

            // Çalışma tercihleri
            'positions'         => $positionsCsv ?: null,
            'position_other'    => trim((string)$req->post('position_other', '')) ?: null,
            'work_type'         => trim((string)$req->post('work_type', '')) ?: null,
            'regions'           => trim((string)$req->post('regions', '')) ?: null,
            'availability'      => trim((string)$req->post('availability', '')) ?: null,

            // Deneyim
            'experience_years'  => max(0, (int)$req->post('experience_years', 0)),
            'prior_experience'  => (int)(bool)$req->post('prior_experience', 0),
            'experience_text'   => trim((string)$req->post('experience_text', '')) ?: null,

            // Kısıtlar
            'travel_constraint' => (int)(bool)$req->post('travel_constraint', 0),
            'night_work'        => (int)(bool)$req->post('night_work', 1),
            'transportation'    => trim((string)$req->post('transportation', '')) ?: null,

            // Ücret
            'daily_rate'        => $req->post('daily_rate', '') !== '' ? (float)$req->post('daily_rate', 0) : null,
            'currency'          => $req->post('currency', 'EUR'),

            // Anlatım & not
            'self_description'  => trim((string)$req->post('self_description', '')) ?: null,
            'notes'             => trim((string)$req->post('notes', '')) ?: null,
            'photo_usage_consent'=> (int)(bool)$req->post('photo_usage_consent', 0),

            // Meta
            'kvkk_accepted'     => (int)(bool)$req->post('kvkk_accepted', false),
            'ip'                => $_SERVER['REMOTE_ADDR'] ?? '',
        ];

        $errors = [];
        if ($data['first_name'] === '')                                                  $errors[] = 'Ad zorunlu.';
        if ($data['last_name']  === '')                                                  $errors[] = 'Soyad zorunlu.';
        if ($data['phone']      === '')                                                  $errors[] = 'Telefon zorunlu.';
        if ($data['email']      === '' || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Geçerli e-posta zorunlu.';
        if (empty($positionsArr))                                                        $errors[] = 'En az bir pozisyon seçmelisiniz.';
        if (!$data['kvkk_accepted'])                                                     $errors[] = 'KVKK onayı zorunlu.';

        if (!empty($errors)) {
            Session::flash('crew_error', implode(' ', $errors));
            Session::flash('crew_old', $data + ['positions' => $positionsArr]);
            View::redirect(url('unifex-crew'));
        }

        // Photo uploads (4 photos + CV)
        $photoFields = ['photo_portrait', 'photo_full', 'photo_profile', 'photo_extra'];
        $uploadDir = BASE_PATH . '/public/uploads/crew';
        if (!is_dir($uploadDir)) @mkdir($uploadDir, 0755, true);

        foreach ($photoFields as $field) {
            if (empty($_FILES[$field]['name']) || $_FILES[$field]['error'] !== UPLOAD_ERR_OK) continue;
            $ext = strtolower(pathinfo($_FILES[$field]['name'], PATHINFO_EXTENSION));
            if (!in_array($ext, ['jpg','jpeg','png','webp'], true)) continue;
            if ($_FILES[$field]['size'] > 8 * 1024 * 1024) continue;
            $name = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_' . $field . '.' . $ext;
            $dest = $uploadDir . '/' . $name;
            if (@move_uploaded_file($_FILES[$field]['tmp_name'], $dest)) {
                $data[$field] = '/uploads/crew/' . $name;
            }
        }

        if (!empty($_FILES['cv']['name']) && $_FILES['cv']['error'] === UPLOAD_ERR_OK) {
            $ext = strtolower(pathinfo($_FILES['cv']['name'], PATHINFO_EXTENSION));
            if (in_array($ext, ['pdf','doc','docx'], true) && $_FILES['cv']['size'] <= 10 * 1024 * 1024) {
                $name = date('Ymd_His') . '_' . substr(uniqid('', true), -6) . '_cv.' . $ext;
                $dest = $uploadDir . '/' . $name;
                if (@move_uploaded_file($_FILES['cv']['tmp_name'], $dest)) {
                    $data['cv_path'] = '/uploads/crew/' . $name;
                }
            }
        }

        try {
            \App\Models\CrewApplication::create($data);
            Session::flash('crew_success', 'Başvurunuz başarıyla alındı! İnceleme sonrası sizinle iletişime geçeceğiz.');
        } catch (\Throwable $e) {
            Session::flash('crew_error', 'Başvuru gönderilemedi: ' . $e->getMessage());
            Session::flash('crew_old', $data + ['positions' => $positionsArr]);
        }
        View::redirect(url('unifex-crew'));
    }

    public function history(Request $req, array $params = []): void   { View::render('history', [], 'main'); }
    public function team(Request $req, array $params = []): void      { View::render('team', [], 'main'); }
    public function mission(Request $req, array $params = []): void   { View::render('mission', [], 'main'); }
    public function references(Request $req, array $params = []): void{ View::render('references', [], 'main'); }
    public function faq(Request $req, array $params = []): void       { View::render('faq', [], 'main'); }
    public function kvkk(Request $req, array $params = []): void      { View::render('legal-kvkk', [], 'main'); }
    public function privacy(Request $req, array $params = []): void   { View::render('legal-privacy', [], 'main'); }
    public function cookies(Request $req, array $params = []): void   { View::render('legal-cookies', [], 'main'); }
    public function terms(Request $req, array $params = []): void     { View::render('legal-terms', [], 'main'); }
}
