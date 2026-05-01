<?php
$pageTitle       = lang() === 'en'
    ? 'Blog | Expo Cyprus — Fair & Congress News from Cyprus'
    : 'Blog | Expo Cyprus — Kıbrıs\'tan Fuar & Kongre Haberleri';
$metaDescription = lang() === 'en'
    ? 'News, tips and insights from the world of fair and congress organisation in Cyprus — by the Expo Cyprus team.'
    : 'Kıbrıs\'ta fuar ve kongre organizasyonu dünyasından haberler, ipuçları ve içgörüler — Expo Cyprus ekibinden.';
$bodyClass = 'page-blog';

$posts    = $data ?? [];
$curPage  = $page ?? 1;
$lastPage = $last_page ?? 1;
$total    = $total ?? 0;
?>

<!-- ═══════════════════════════════════════════════════════════════
     PAGE HERO
═══════════════════════════════════════════════════════════════ -->
<section class="page-hero page-hero-dark">
    <div class="page-hero-overlay"></div>
    <div class="container">
        <div class="page-hero-content">
            <nav class="breadcrumb" aria-label="Breadcrumb">
                <a href="<?= url() ?>"><?= lang() === 'en' ? 'Home' : 'Anasayfa' ?></a>
                <span aria-hidden="true">›</span>
                <span>Blog</span>
            </nav>
            <h1 class="page-hero-title">Blog</h1>
            <p class="page-hero-subtitle">
                <?= lang() === 'en'
                    ? 'News, tips and industry insights from the Expo Cyprus team.'
                    : 'Expo Cyprus ekibinden haberler, ipuçları ve sektör içgörüleri.' ?>
            </p>
        </div>
    </div>
</section>

<!-- ═══════════════════════════════════════════════════════════════
     BLOG GRİDİ
═══════════════════════════════════════════════════════════════ -->
<section class="section section-blog">
    <div class="container">

        <?php if (!empty($posts)): ?>
        <div class="blog-grid blog-grid-full">
            <?php foreach ($posts as $post):
                $postTitle   = lang() === 'en' ? ($post['title_en'] ?? $post['title']) : ($post['title_tr'] ?? $post['title']);
                $postExcerpt = lang() === 'en' ? ($post['excerpt_en'] ?? $post['excerpt'] ?? '') : ($post['excerpt_tr'] ?? $post['excerpt'] ?? '');
                if (empty($postExcerpt)) {
                    $postExcerpt = mb_substr(strip_tags($post['content'] ?? ''), 0, 140);
                }
                $postDate = !empty($post['published_at']) ? date('d.m.Y', strtotime($post['published_at'])) : '';
                $postDatetime = !empty($post['published_at']) ? date('Y-m-d', strtotime($post['published_at'])) : '';
            ?>
            <article class="blog-card">
                <?php if (!empty($post['image'])): ?>
                <a href="<?= url('blog/' . $post['slug']) ?>" class="blog-card-img-wrap">
                    <img src="<?= e($post['image']) ?>" alt="<?= e($postTitle) ?>" loading="lazy">
                </a>
                <?php else: ?>
                <a href="<?= url('blog/' . $post['slug']) ?>" class="blog-card-img-wrap blog-card-img-placeholder">
                    <svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                        <rect x="3" y="3" width="18" height="18" rx="2"/>
                        <circle cx="8.5" cy="8.5" r="1.5"/>
                        <polyline points="21 15 16 10 5 21"/>
                    </svg>
                </a>
                <?php endif; ?>
                <div class="blog-card-body">
                    <?php if ($postDate): ?>
                    <time class="blog-card-date" datetime="<?= $postDatetime ?>">
                        <?= $postDate ?>
                    </time>
                    <?php endif; ?>
                    <?php if (!empty($post['category'])): ?>
                    <span class="blog-card-cat"><?= e($post['category']) ?></span>
                    <?php endif; ?>
                    <h3 class="blog-card-title">
                        <a href="<?= url('blog/' . $post['slug']) ?>"><?= e($postTitle) ?></a>
                    </h3>
                    <?php if ($postExcerpt): ?>
                    <p class="blog-card-excerpt"><?= e($postExcerpt) ?>...</p>
                    <?php endif; ?>
                    <a href="<?= url('blog/' . $post['slug']) ?>" class="blog-card-link">
                        <?= lang() === 'en' ? 'Read More' : 'Devamını Oku' ?> <span aria-hidden="true">→</span>
                    </a>
                </div>
            </article>
            <?php endforeach; ?>
        </div>

        <!-- Pagination -->
        <?php if ($lastPage > 1): ?>
        <nav class="pagination" aria-label="<?= lang() === 'en' ? 'Page navigation' : 'Sayfa navigasyonu' ?>">
            <?php if ($curPage > 1): ?>
            <a href="?page=<?= $curPage - 1 ?>" class="pagination-link pagination-prev">
                <span aria-hidden="true">←</span> <?= lang() === 'en' ? 'Previous' : 'Önceki' ?>
            </a>
            <?php endif; ?>

            <?php for ($i = max(1, $curPage - 2); $i <= min($lastPage, $curPage + 2); $i++): ?>
            <a href="?page=<?= $i ?>"
               class="pagination-link <?= $i === $curPage ? 'pagination-link-active' : '' ?>"
               <?= $i === $curPage ? 'aria-current="page"' : '' ?>>
                <?= $i ?>
            </a>
            <?php endfor; ?>

            <?php if ($curPage < $lastPage): ?>
            <a href="?page=<?= $curPage + 1 ?>" class="pagination-link pagination-next">
                <?= lang() === 'en' ? 'Next' : 'Sonraki' ?> <span aria-hidden="true">→</span>
            </a>
            <?php endif; ?>
        </nav>
        <?php endif; ?>

        <?php else: ?>
        <div class="empty-state">
            <svg width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" aria-hidden="true">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                <polyline points="14 2 14 8 20 8"/>
                <line x1="16" y1="13" x2="8" y2="13"/>
                <line x1="16" y1="17" x2="8" y2="17"/>
                <polyline points="10 9 9 9 8 9"/>
            </svg>
            <h3><?= lang() === 'en' ? 'No posts yet' : 'Henüz yazı yok' ?></h3>
            <p><?= lang() === 'en' ? 'Blog content is being prepared. Check back soon.' : 'Blog içeriği hazırlanıyor. Yakında tekrar ziyaret edin.' ?></p>
        </div>
        <?php endif; ?>

    </div>
</section>

<style>
.page-hero {
    position: relative;
    min-height: 340px;
    display: flex;
    align-items: center;
    background-size: cover;
    background-position: center;
    color: var(--white);
    padding: var(--space-4xl) 0 var(--space-3xl);
}
.page-hero-dark { background-color: var(--gray-900); }
.page-hero-overlay {
    position: absolute;
    inset: 0;
    background: linear-gradient(135deg, rgba(10,10,10,.85) 0%, rgba(227,6,19,.3) 100%);
}
.page-hero .container { position: relative; z-index: 1; }
.page-hero-content { max-width: 640px; }
.page-hero-title { font-size: var(--font-size-5xl); font-weight: 800; color: var(--white); margin: .5rem 0; }
.page-hero-subtitle { font-size: var(--font-size-lg); color: rgba(255,255,255,.85); margin-top: .75rem; }
.breadcrumb { display: flex; align-items: center; gap: .5rem; font-size: var(--font-size-sm); color: rgba(255,255,255,.7); margin-bottom: .5rem; }
.breadcrumb a { color: rgba(255,255,255,.7); }
.breadcrumb a:hover { color: var(--white); }

.blog-grid-full { grid-template-columns: repeat(3, 1fr); }
.blog-card-cat {
    display: inline-block;
    font-size: var(--font-size-xs);
    font-weight: 600;
    color: var(--red);
    text-transform: uppercase;
    letter-spacing: .06em;
    margin-bottom: .25rem;
}
.blog-card-link {
    display: inline-flex;
    align-items: center;
    gap: .375rem;
    font-size: var(--font-size-sm);
    font-weight: 600;
    color: var(--red);
    margin-top: var(--space-sm);
}
.blog-card-img-placeholder {
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 200px;
    color: var(--gray-400);
}
.pagination {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .5rem;
    margin-top: var(--space-3xl);
    flex-wrap: wrap;
}
.pagination-link {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    min-width: 40px;
    height: 40px;
    padding: 0 .75rem;
    border: 1px solid var(--border);
    border-radius: var(--radius-sm);
    font-size: var(--font-size-sm);
    font-weight: 500;
    color: var(--gray-700);
    transition: all var(--transition);
}
.pagination-link:hover { border-color: var(--red); color: var(--red); }
.pagination-link-active { background: var(--red); border-color: var(--red); color: var(--white); }
.pagination-prev, .pagination-next { gap: .375rem; }
.empty-state { text-align: center; padding: var(--space-4xl) 0; color: var(--text-muted); }
.empty-state svg { margin: 0 auto var(--space-lg); color: var(--gray-300); }
.empty-state h3 { font-size: var(--font-size-xl); color: var(--gray-600); margin-bottom: .5rem; }
@media (max-width: 960px) { .blog-grid-full { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 600px) {
    .blog-grid-full { grid-template-columns: 1fr; }
    .page-hero-title { font-size: var(--font-size-4xl); }
}
</style>
