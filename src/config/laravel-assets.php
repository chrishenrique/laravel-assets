<?php

return [
    'global_assets' => [
        'script' => [
            'jquery' => [
                'url' => 'https://code.jquery.com/jquery-3.6.0.min.js',
                'position' => 'body',
                'order' => 1,
            ],
        ],
        'style' => [
            'bootstrap' => [
                'url' => 'https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css',
                'position' => 'head',
                'order' => 1,
            ],
        ],
    ],
    'asset_groups' => [
        'admin' => [
            'script' => [
                'admin-js' => [
                    'url' => 'https://cdn.jsdelivr.net/npm/admin.js',
                    'position' => 'body',
                ],
            ],
            'style' => [
                'admin-css' => [
                    'url' => 'https://cdn.jsdelivr.net/npm/admin.css',
                    'position' => 'head',
                ],
            ],
        ],
        'public' => [
            'script' => [
                'jquery' => [
                    'url' => 'https://code.jquery.com/jquery-3.6.0.min.js',
                    'position' => 'head',
                ],
            ],
        ],
    ],
    'assets' => [
        'fullcalendar' => [
            'script' => [
                'url' => 'https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js',
                'position' => 'body',
            ],
        ],
    ],
];