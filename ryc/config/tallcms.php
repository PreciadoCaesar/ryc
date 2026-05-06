<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Site Settings
    |--------------------------------------------------------------------------
    */

    'site_name' => env('TALLCMS_SITE_NAME', 'R&C Consulting'),
    'site_description' => env('TALLCMS_SITE_DESCRIPTION', 'Especialistas en gestión pública y capacitación'),
    'site_keywords' => env('TALLCMS_SITE_KEYWORDS', 'gestión pública, capacitación, cursos, diplomados'),

    /*
    |--------------------------------------------------------------------------
    | SEO Defaults
    |--------------------------------------------------------------------------
    */

    'seo' => [
        'meta' => [
            'title' => 'R&C Consulting',
            'description' => 'Especialistas en gestión pública y capacitación. +23 años formando profesionales.',
            'keywords' => ['gestión pública', 'capacitación', 'cursos', 'diplomados', 'Laravel'],
        ],
        'og' => [
            'type' => 'website',
            'image' => '/img/og-default.jpg',
            'image_width' => 1200,
            'image_height' => 630,
        ],
        'twitter' => [
            'card' => 'summary_large_image',
            'site' => '@rycconsulting',
        ],
        'schema_org' => [
            'enable' => true,
            'type' => 'Organization',
        ],
        'sitemap' => [
            'enable' => true,
            'path' => 'sitemap.xml',
        ],
        'robots' => [
            'enable' => true,
            'content' => "User-agent: *\nAllow: /\n",
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Media Settings
    |--------------------------------------------------------------------------
    */

    'media' => [
        'disk' => 'public',
        'collections' => [
            'default' => [
                'name' => 'Default',
                'path' => 'tallcms/media',
            ],
            'images' => [
                'name' => 'Images',
                'path' => 'tallcms/images',
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Content Settings
    |--------------------------------------------------------------------------
    */

    'content' => [
        'posts_per_page' => 10,
        'excerpt_length' => 250,
        'allow_comments' => false,
        'date_format' => 'd/m/Y',
    ],

    /*
    |--------------------------------------------------------------------------
    | Block Editor
    |--------------------------------------------------------------------------
    */

    'blocks' => [
        'enabled' => [
            'text',
            'image',
            'video',
            'testimonial',
            'card',
            'accordion',
            'tabs',
            'carousel',
            'contact-form',
        ],
    ],

];
