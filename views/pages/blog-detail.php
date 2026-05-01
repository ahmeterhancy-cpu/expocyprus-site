<?php
$postTitle   = lang() === 'en' ? ($post['title_en'] ?? $post['title']) : ($post['title_tr'] ?? $post['title']);
$postContent = lang() === 'en' ? ($post['content_en'] ?? $post['content'] ?? '') : ($post['content_tr'] ?? $post['content'] ?? '');
$postExcerpt = lang() === 'en' ? ($post['excerpt_en'] ?? $post['excerpt'] ?? '') : ($post['excerpt_tr'] ?? $post['excerpt'] ?? '');
if (empty($postExcerpt)) {
    $postExcerpt = mb_substr(strip_tags($postContent), 0, 160);
}

$pageTitle       = e($postTitle) . ' | Expo Cyprus Blog';
$metaDescription = e(mb_substr($postExcerpt, 0, 160));
$bodyClass       = 'page-blog-detail';
$postDate        = !empty($post['published_at']) ? date('d.m.Y', strtotime($post['published_at'])) : '';
$postDatetime    = !empty($post['published_at']) ? date('Y-m-d', strtotime($post['published_at'])) : '';
?>

<!-- ═══════════════════════════════════════════════════════════════
     FEATURED IMAGE HEADER
═══════════════════════════════════════════════════════════════ -->
<?php if (!empty($post['image'])): ?>
<section class="post-hero" style="background-image: url('<?= e($post['image']) ?>');">
    <div class="post-hero-overlay"></div>
</section>
<?php endif; ?>

<!-- ═══════════════════════════════════════════════════════════════
     MAKALE İÇERİĞİ
═══════════════════════════════════════════════════════════════ -->
<section class="section">
    <div class="container">
        <div class="post-layout">

            <article class="post-main">
                <!-- Breadcrumb & Back -->
                <nav class="breadcrumb post-breadcrumb" aria-label="Breadcrumb">
                    <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                    <span aria-hidden="true">›</span>
                    <a href="<?= url('blog') ?>">Blog</a>
                    <span aria-hidden="true">›</span>
                    <span><?= e(mb_substr($postTitle, 0, 50)) . (mb_strlen($postTitle) > 50 ? '...' : '') ?></span>
                </nav>

                <!-- Meta -->
                <header class="post-header">
                    <?php if (!empty($post['category'])): ?>
                    <span class="post-category"><?= e($post['category']) ?></span>
                    <?php endif; ?>
                    <h1 class="post-title"><?= e($postTitle) ?></h1>
                    <div class="post-meta">
                        <?php if ($postDate): ?>
                        <time datetime="<?= $postDatetime ?>" class="post-meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <rect x="3" y="4" width="18" height="18" rx="2"/>
                                <line x1="16" y1="2" x2="16" y2="6"/>
                                <line x1="8" y1="2" x2="8" y2="6"/>
                                <line x1="3" y1="10" x2="21" y2="10"/>
                            </svg>
                            <?= $postDate ?>
                        </time>
                        <?php endif; ?>
                        <?php if (!empty($post['author'])): ?>
                        <span class="post-meta-item">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" aria-hidden="true">
                                <path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/>
                                <circle cx="12" cy="7" r="4"/>
                            </svg>
                            <?= e($post['author']) ?>
                        </span>
                        <?php endif; ?>
                    </div>
                </header>

                <!-- İçerik -->
                <div class="prose post-content">
                    <?= $postContent ?: '<p>' . e($postExcerpt) . '</p>' ?>
                </div>

                <!-- Alt Navigasyon -->
                <div class="post-footer">
                    <a href="<?= url('blog') ?>" class="btn btn-outline">
                        <span aria-hidden="true">←</span>
                        <?= lang() === 'en' ? 'Back to Blog' : "Blog'a Dön" ?>
                    </a>
                </div>
            </article>

            <!-- Kenar Çubuğu -->
            <aside class="detail-sidebar">
                <div class="sidebar-card">
                    <h3 class="sidebar-card-title">
                        <?= lang() === 'en' ? 'About Expo Cyprus' : 'Expo Cyprus Hakkında' ?>
                    </h3>
                    <p class="sidebar-card-text">
                        <?= lang() === 'en'
                            ? 'We\'ve been organising fairs, congresses and stands in Cyprus for over 22 years. Get in touch to see how we can help you.'
                            : '22 yılı aşkın süredir Kıbrıs\'ta fuar, kongre ve stand organizasyonu yapıyoruz. Nasıl yardımcı olabileceğimizi öğrenmek için iletişime geçin.' ?>
                    </p>
                    <a href="<?= url('teklif-al') ?>" class="btn btn-primary btn-block" style="margin-bottom:.75rem;">
                        <?= lang() === 'en' ? 'Get a Quote' : 'Teklif Al' ?>
                    </a>
                    <a href="<?= url('iletisim') ?>" class="btn btn-outline btn-block">
                        <?= lang() === 'en' ? 'Contact Us' : 'İletişime Geç' ?>
                    </a>
                </div>

                <div class="sidebar-card" style="margin-top:var(--space-lg);">
                    <h3 class="sidebar-card-title" style="font-size:var(--font-size-sm);">
                        <?= lang() === 'en' ? 'Our Services' : 'Hizmetlerimiz' ?>
                    </h3>
                    <ul class="sidebar-link-list">
                        <?php $sidebarServices = [
                            ['slug' => 'fuar-organizasyonu',       'tr' => 'Fuar Organizasyonu',       'en' => 'Fair Organisation'],
                            ['slug' => 'kongre-organizasyonu',     'tr' => 'Kongre Organizasyonu',     'en' => 'Congress Organisation'],
                            ['slug' => 'stand-tasarim-kurulum',    'tr' => 'Stand Tasarım & Kurulum',  'en' => 'Stand Design & Build'],
                            ['slug' => 'fuar-katilim-danismanligi','tr' => 'Fuar Katılım Danışmanlığı','en' => 'Exhibition Consulting'],
                        ];
                        foreach ($sidebarServices as $ss): ?>
                        <li>
                            <a href="<?= url('hizmetler/' . $ss['slug']) ?>">
                                <?= lang() === 'en' ? $ss['en'] : $ss['tr'] ?> <span aria-hidden="true">→</span>
                            </a>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </aside>

        </div>
    </div>
</section>

<style>
.post-hero {
    height: 420px;
    background-size: cover;
    background-position: center;
    position: relative;
}
.post-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(to bottom, transparent 40%, rgba(10,10,10,.3) 100%);
}
.post-layout { display: grid; grid-template-columns: 1fr 300px; gap: var(--space-3xl); align-items: start; }
.post-main { min-width: 0; }
.post-breadcrumb { margin-bottom: var(--space-xl); }
.breadcrumb { display: flex; align-items: center; gap: .5rem; flex-wrap: wrap; font-size: var(--font-size-sm); color: var(--text-muted); }
.breadcrumb a { color: var(--text-muted); }
.breadcrumb a:hover { color: var(--red); }
.post-category {
    display: inline-block;
    font-size: var(--font-size-xs);
    font-weight: 700;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: .75rem;
    background: var(--red-light);
    padding: .25rem .75rem;
    border-radius: var(--radius-sm);
}
.post-title { font-size: var(--font-size-4xl); font-weight: 800; line-height: 1.15; margin-bottom: var(--space-lg); }
.post-meta { display: flex; align-items: center; gap: var(--space-lg); flex-wrap: wrap; margin-bottom: var(--space-2xl); padding-bottom: var(--space-xl); border-bottom: 1px solid var(--border); }
.post-meta-item { display: flex; align-items: center; gap: .375rem; font-size: var(--font-size-sm); color: var(--text-muted); }
.prose { line-height: 1.8; color: var(--gray-700); }
.prose h2, .prose h3 { color: var(--text); margin: 1.75em 0 .5em; }
.prose p { margin-bottom: 1.125em; }
.prose ul, .prose ol { padding-left: 1.5em; margin-bottom: 1.125em; }
.prose li { margin-bottom: .375em; }
.prose a { color: var(--red); }
.prose img { border-radius: var(--radius-md); margin: 1.5em 0; max-width: 100%; }
.prose blockquote { border-left: 4px solid var(--red); padding: var(--space-md) var(--space-lg); background: var(--gray-50); border-radius: 0 var(--radius-sm) var(--radius-sm) 0; margin: 1.5em 0; font-style: italic; }
.post-footer { margin-top: var(--space-3xl); padding-top: var(--space-xl); border-top: 1px solid var(--border); }
.sidebar-card { background: var(--gray-50); border: 1px solid var(--border); border-radius: var(--radius-lg); padding: var(--space-xl); }
.sidebar-card-title { font-size: var(--font-size-base); margin-bottom: .5rem; }
.sidebar-card-text { font-size: var(--font-size-sm); color: var(--text-muted); margin-bottom: var(--space-lg); line-height: 1.6; }
.sidebar-link-list { list-style: none; padding: 0; margin-top: .75rem; display: flex; flex-direction: column; gap: .25rem; }
.sidebar-link-list a { display: block; padding: .5rem .75rem; font-size: var(--font-size-sm); color: var(--gray-700); border-radius: var(--radius-sm); transition: all var(--transition); }
.sidebar-link-list a:hover { background: var(--red-light); color: var(--red); }
@media (max-width: 960px) {
    .post-layout { grid-template-columns: 1fr; }
    .post-title { font-size: var(--font-size-3xl); }
    .post-hero { height: 280px; }
}
</style>
