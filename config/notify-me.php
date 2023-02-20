<?php

use Lokalkoder\NotifyMe\NotifyMe\Listener\NotifyMeSent;

return [
    /*
    |--------------------------------------------------------------------------
    | Lokalkoder/NotifyMe Config
    |--------------------------------------------------------------------------
    |
    | This default configuration for lokalkoder/notify-me package.
    | All essential config are listed and define here.
    |
    */
    'header' => env('NM_HEADER', 'Notify Me'),

    'pick-me' => [
        'recipient' => [
            'source' => env('NM_RECIPIENT_SOURCE', 'App\Models\User'),
            'field' => [
                'name' => env('NM_RECIPIENT_NAME', 'name'),
                'email' => env('NM_RECIPIENT_EMAIL', 'email'),
            ],
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lokalkoder/NotifyMe Queue Config
    |--------------------------------------------------------------------------
    |
    | Definition for queue use by the package.
    |
    */
    'queue' => [
        'mail' => [
            'connection' => env('QUEUE_CONNECTION', 'sync'),
            'name' => env('NM_QUEUE_MAIL', 'notify-me-mail'),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Lokalkoder/NotifyMe Listener
    |--------------------------------------------------------------------------
    |
    | Definition of listener class use by package
    |
    */
    'listener' => [
        'mail' => [
            'sending' => [],
            'sent' => [
                NotifyMeSent::class,
            ],
        ],
    ],
];
