<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Default rendering options
    |--------------------------------------------------------------------------
    |
    | This section contains the default rendering options for the icons.
    |
    */

    'defaults' => [

        /*
        |--------------------------------------------------------------------------
        | Default class names
        |--------------------------------------------------------------------------
        |
        | The default class names to apply to all rendered icons.
        |
        */

        'class' => '',

    ],

    /*
    |--------------------------------------------------------------------------
    | Cache configuration
    |--------------------------------------------------------------------------
    |
    | This section contains the configuration options for the icon cache.
    |
    */

    'cache' => [
        'disk' => [
            'driver' => 'local',
            'path' => 'icons',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Component name
    |--------------------------------------------------------------------------
    |
    | This value is the name that will be used to register the Blade component
    | and directive.
    |
    */

    'name' => 'icon',

    /*
    |--------------------------------------------------------------------------
    | Iconify options
    |--------------------------------------------------------------------------
    |
    | This section contains the configuration options for the Iconify API.
    |
    */

    'iconify' => [
        'url' => 'https://api.iconify.design',
        'timeout' => 5,
    ],

];
