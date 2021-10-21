<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Image Driver
    |--------------------------------------------------------------------------
    |
    | Intervention Image supports "GD Library" and "Imagick" to process images
    | internally. You may choose one of them according to your PHP
    | configuration. By default PHP's "GD Library" implementation is used.
    |
    | Supported: "gd", "imagick"
    |
    */

    'driver' => 'gd',
    'sizes' => [
        'fullwidth' => [
            [1920, 1920, 800],
            [1368, 1368, 570],
            [400, 375, 375]
        ],
        'card' => [
            [1200, 378, 264],
            [1024, 320, 224],
            [768, 363, 224],
        ]
    ],

];
