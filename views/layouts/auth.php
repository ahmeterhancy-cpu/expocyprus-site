<!DOCTYPE html>
<html lang="<?= lang() ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="robots" content="noindex, nofollow">
    <title><?= e($pageTitle ?? 'Üye Girişi | Expo Cyprus') ?></title>

    <link rel="icon" type="image/svg+xml" href="<?= asset('img/logo/unifex-mark-only.svg') ?>">
    <link rel="apple-touch-icon" href="<?= asset('img/logo/unifex-mark-only.svg') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        html, body { height: 100%; }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
            background: linear-gradient(135deg, #0a0a0a 0%, #1d1d1f 100%);
            color: #1d1d1f;
            min-height: 100vh;
            min-height: 100svh;
            display: flex;
            flex-direction: column;
        }
        a { color: inherit; text-decoration: none; }

        /* Reusable styles for member auth */
        .container { width: 100%; max-width: 1200px; margin: 0 auto; padding: 0 1rem; }

        /* ═══ Member Auth — Base Styles (login + register) ═══ */
        .ma-section { width: 100%; display: flex; align-items: center; justify-content: center; padding: 1rem; }
        .ma-box {
            max-width: 460px; width: 100%; margin: 0 auto;
            background: #fff; border-radius: 24px;
            padding: clamp(1.75rem, 5vw, 3rem) clamp(1.5rem, 4vw, 2.5rem);
            box-shadow: 0 20px 60px rgba(0,0,0,.3);
        }
        .ma-box-wide { max-width: 760px; }
        .ma-brand { text-align: center; margin-bottom: 2rem; }
        .ma-brand img { max-width: 160px; height: auto; }
        .ma-brand p {
            margin: .5rem 0 0; color: #6e6e73;
            font-size: .8125rem; letter-spacing: .15em;
            text-transform: uppercase; font-weight: 600;
        }
        .ma-box h1 {
            font-size: clamp(1.5rem, 4vw, 1.875rem); font-weight: 700;
            text-align: center; margin: 0 0 .5rem; color: #1d1d1f;
        }
        .ma-sub {
            text-align: center; color: #6e6e73;
            margin: 0 0 2rem; font-size: .9375rem;
        }
        .ma-flash {
            padding: .85rem 1rem; border-radius: 12px;
            font-size: .875rem; margin-bottom: 1.25rem;
        }
        .ma-flash-ok  { background: #ecfdf5; color: #065f46; border-left: 4px solid #10b981; }
        .ma-flash-err { background: #fef2f2; color: #991b1b; border-left: 4px solid #ef4444; }

        .ma-form { display: flex; flex-direction: column; gap: 1rem; }
        .ma-form-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; }
        .ma-col-2 { grid-column: 1 / -1; }

        .ma-field label {
            display: block; font-size: .8125rem; font-weight: 600;
            color: #1d1d1f; margin-bottom: .375rem;
        }
        .ma-field label small { color: #86868b; font-weight: 400; font-size: .75rem; }
        .ma-field input,
        .ma-field select,
        .ma-field textarea {
            width: 100%; padding: .75rem 1rem;
            border: 1px solid #d2d2d7; border-radius: 12px;
            font-size: 16px; /* iOS zoom prevention */
            font-family: inherit;
            background: #fff; color: #1d1d1f;
            transition: border-color .2s, box-shadow .2s;
        }
        .ma-field input:focus,
        .ma-field select:focus,
        .ma-field textarea:focus {
            outline: 0; border-color: #E30613;
            box-shadow: 0 0 0 3px rgba(227,6,19,.1);
        }
        .ma-field textarea { resize: vertical; min-height: 80px; }
        .ma-field input[disabled] { background: #f5f5f7; color: #86868b; cursor: not-allowed; }

        .ma-btn {
            padding: 1rem 1.5rem; border-radius: 12px;
            font-size: 1rem; font-weight: 600;
            cursor: pointer; border: 0;
            transition: all .2s;
            font-family: inherit;
        }
        .ma-btn-primary { background: #E30613; color: #fff; }
        .ma-btn-primary:hover { background: #c00510; transform: translateY(-1px); box-shadow: 0 8px 20px -8px #E30613; }

        .ma-kvkk {
            background: #f5f5f7; padding: 1rem;
            border-radius: 12px; grid-column: 1 / -1;
        }
        .ma-check {
            display: flex; gap: .5rem; align-items: flex-start;
            font-size: .875rem; cursor: pointer; line-height: 1.5;
        }
        .ma-check input { margin-top: .25rem; flex-shrink: 0; accent-color: #E30613; }
        .ma-check a { color: #E30613; text-decoration: underline; }

        .ma-foot {
            text-align: center; margin: 2rem 0 .5rem;
            color: #6e6e73; font-size: .9375rem;
        }
        .ma-foot a { color: #E30613; text-decoration: none; }
        .ma-foot a:hover { text-decoration: underline; }
        .ma-back { text-align: center; margin: 0; font-size: .8125rem; }
        .ma-back a { color: #86868b; }
        .ma-back a:hover { color: #1d1d1f; }

        @media (max-width: 600px) {
            .ma-form-2col { grid-template-columns: 1fr; }
            .ma-box { padding: 1.5rem 1.25rem; border-radius: 18px; }
        }
    </style>
</head>
<body class="<?= e($bodyClass ?? '') ?>">
    <main style="flex:1; display:flex; align-items:center; padding: 2rem 1rem;">
        <?= $content ?>
    </main>
</body>
</html>
