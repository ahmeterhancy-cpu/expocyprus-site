<?php
declare(strict_types=1);

namespace App\Controllers\Admin;

use App\Core\{Request, Session, View};
use App\Models\{BlogPost, MediaFile};

class BlogController
{
    public function index(Request $req, array $params = []): void
    {
        $posts = BlogPost::all('published_at DESC');
        View::render('admin/blog/index', compact('posts'), 'admin');
    }

    public function create(Request $req, array $params = []): void
    {
        View::render('admin/blog/edit', ['post' => null, 'isNew' => true], 'admin');
    }

    public function store(Request $req, array $params = []): void
    {
        $data = $this->formData($req);
        $data['slug'] = slug($data['title'] ?? 'post') . '-' . time();
        BlogPost::create($data);
        Session::flash('success', 'Blog yazısı eklendi.');
        View::redirect('/admin/blog');
    }

    public function edit(Request $req, array $params = []): void
    {
        $post = BlogPost::find((int)$params['id']);
        if (!$post) View::redirect('/admin/blog');
        View::render('admin/blog/edit', ['post' => $post, 'isNew' => false], 'admin');
    }

    public function update(Request $req, array $params = []): void
    {
        BlogPost::update((int)$params['id'], $this->formData($req));
        Session::flash('success', 'Blog yazısı güncellendi.');
        View::redirect('/admin/blog');
    }

    public function destroy(Request $req, array $params = []): void
    {
        BlogPost::delete((int)$params['id']);
        Session::flash('success', 'Blog yazısı silindi.');
        View::redirect('/admin/blog');
    }

    private function formData(Request $req): array
    {
        $pubAt = trim($req->post('published_at', ''));

        // Cover image: uploaded file takes priority, otherwise keep existing URL
        $image    = trim($req->post('image_current', '')) ?: trim($req->post('image', ''));
        $imgFile  = $req->file('image_file');
        if ($imgFile && $imgFile['error'] === UPLOAD_ERR_OK && !empty($imgFile['name'])) {
            $result = MediaFile::upload($imgFile, 'blog');
            if ($result) $image = $result['url'];
        }

        return [
            'lang'         => $req->post('lang', 'tr'),
            'title'        => trim($req->post('title', '')),
            'excerpt'      => trim($req->post('excerpt', '')),
            'content'      => $req->post('content', ''),
            'image'        => $image,
            'author'       => trim($req->post('author', 'Expo Cyprus')),
            'category'     => trim($req->post('category', '')),
            'tags'         => trim($req->post('tags', '')),
            'status'       => $req->post('status', 'draft'),
            'meta_title'   => trim($req->post('meta_title', '')),
            'meta_desc'    => trim($req->post('meta_desc', '')),
            'published_at' => $pubAt ?: null,
        ];
    }
}
