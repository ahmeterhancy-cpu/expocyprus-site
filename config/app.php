<?php
declare(strict_types=1);

return [
    'name'      => env('APP_NAME', 'Expo Cyprus'),
    'env'       => env('APP_ENV', 'production'),
    'debug'     => (bool) env('APP_DEBUG', false),
    'url'       => env('APP_URL', 'https://www.expocyprus.com'),
    'timezone'  => env('APP_TIMEZONE', 'Europe/Nicosia'),
    'secret'    => env('APP_SECRET', 'change-me'),

    'languages' => ['tr', 'en'],
    'default_lang' => 'tr',

    'session_lifetime' => (int) env('SESSION_LIFETIME', 120),

    'recaptcha_site'   => env('RECAPTCHA_SITE_KEY', ''),
    'recaptcha_secret' => env('RECAPTCHA_SECRET_KEY', ''),
    'ga_id'            => env('GA_MEASUREMENT_ID', ''),
    'fb_pixel'         => env('FB_PIXEL_ID', ''),

    'brand' => [
        'name'    => 'Expo Cyprus',
        'legal'   => 'Unifex Fuarcılık Organizasyon Ltd.',
        'tagline' => '22 Yıllık Deneyim.',
        'founded' => 2004,
        'email'   => 'info@expocyprus.com',
        'phone'   => '+90 548 830 3000',
        'phone2'  => '+90 548 840 4000',
        'address' => 'Lefkoşa, KKTC',
        'social'  => [
            'linkedin'  => '',
            'instagram' => '',
            'facebook'  => '',
            'youtube'   => '',
        ],
    ],
];
