<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\Hotel;

class HotelsController
{
    public function index(Request $req, array $params = []): void
    {
        $hotels = Hotel::all('sort_order ASC');
        View::render('admin/hotels/index', compact('hotels'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/hotels/edit', ['hotel' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        $data = $this->formData($req);
        $base = slug($req->post('name', '')) ?: 'hotel';
        $data['slug'] = $base . '-' . substr(uniqid('', true), -6);
        Hotel::create($data);
        Session::flash('success', 'Otel eklendi.');
        View::redirect('/admin/hotels');
    }

    public function edit(Request $req, array $params = []): void
    {
        $hotel = Hotel::find((int)$params['id']);
        if (!$hotel) View::redirect('/admin/hotels');
        View::render('admin/hotels/edit', ['hotel' => $hotel, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        Hotel::update((int)$params['id'], $this->formData($req));
        Session::flash('success', 'Otel güncellendi.');
        View::redirect('/admin/hotels');
    }

    public function destroy(Request $req, array $params = []): void
    {
        Hotel::delete((int)$params['id']);
        Session::flash('success', 'Otel silindi.');
        View::redirect('/admin/hotels');
    }

    private function formData(Request $req): array
    {
        // Features: each line = one feature
        $featuresRaw = trim((string)$req->post('features', ''));
        $features = [];
        if ($featuresRaw !== '') {
            foreach (preg_split('/\r\n|\r|\n/', $featuresRaw) as $line) {
                $line = trim($line);
                if ($line !== '') $features[] = $line;
            }
        }

        // Gallery: each line = one URL
        $galleryRaw = trim((string)$req->post('gallery', ''));
        $gallery = [];
        if ($galleryRaw !== '') {
            foreach (preg_split('/\r\n|\r|\n/', $galleryRaw) as $line) {
                $line = trim($line);
                if ($line !== '') $gallery[] = $line;
            }
        }

        $stars = (int)$req->post('stars', 5);
        if ($stars < 1) $stars = 1;
        if ($stars > 5) $stars = 5;

        $rooms = $req->post('rooms', '');
        $rooms = ($rooms === '' || $rooms === null) ? null : (int)$rooms;

        $meetingRooms = $req->post('meeting_rooms', '');
        $meetingRooms = ($meetingRooms === '' || $meetingRooms === null) ? null : (int)$meetingRooms;

        // Event types: array of selected checkboxes
        $eventTypes = (array)$req->post('event_types', []);
        $eventTypes = array_values(array_filter(array_map('trim', $eventTypes), fn($v) => $v !== ''));

        return [
            'name'            => trim($req->post('name', '')),
            'region'          => trim($req->post('region', '')),
            'location'        => trim($req->post('location', '')),
            'stars'           => $stars,
            'summary_tr'      => trim($req->post('summary_tr', '')),
            'summary_en'      => trim($req->post('summary_en', '')),
            'description_tr'  => $req->post('description_tr', ''),
            'description_en'  => $req->post('description_en', ''),
            'features_json'   => json_encode($features, JSON_UNESCAPED_UNICODE),
            'image_main'      => trim($req->post('image_main', '')),
            'gallery_json'    => json_encode($gallery, JSON_UNESCAPED_UNICODE),
            'website_url'     => trim($req->post('website_url', '')),
            'phone'           => trim($req->post('phone', '')),
            'rooms'           => $rooms,
            'meeting_rooms'   => $meetingRooms,
            'event_types_json'=> json_encode($eventTypes, JSON_UNESCAPED_UNICODE),
            'sort_order'      => (int)$req->post('sort_order', 0),
            'status'          => $req->post('status', 'active'),
            'meta_title_tr'   => trim($req->post('meta_title_tr', '')),
            'meta_title_en'   => trim($req->post('meta_title_en', '')),
            'meta_desc_tr'    => trim($req->post('meta_desc_tr', '')),
            'meta_desc_en'    => trim($req->post('meta_desc_en', '')),
        ];
    }
}
