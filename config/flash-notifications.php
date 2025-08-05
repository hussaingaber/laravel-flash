<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | CSS Framework
    |--------------------------------------------------------------------------
    |
    | Specify which CSS framework to use for flash notifications.
    | Supported: "bootstrap", "tailwind"
    |
    */
    'framework' => env('FLASH_FRAMEWORK', 'bootstrap'),

    /*
    |--------------------------------------------------------------------------
    | Auto Display
    |--------------------------------------------------------------------------
    |
    | Automatically display flash messages in views
    |
    */
    'auto_display' => true,

    /*
    |--------------------------------------------------------------------------
    | Animation Duration
    |--------------------------------------------------------------------------
    |
    | Duration for fade animations in milliseconds
    |
    */
    'animation_duration' => 5000,

    /*
    |--------------------------------------------------------------------------
    | Dismissible
    |--------------------------------------------------------------------------
    |
    | Allow users to dismiss notifications
    |
    */
    'dismissible' => true,
];
