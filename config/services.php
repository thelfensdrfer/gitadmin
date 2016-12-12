<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, SparkPost and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'rollbar' => [
        'token' => [
            'server' => env('ROLLBAR_TOKEN_SERVER'),
            'client' => env('ROLLBAR_TOKEN_CLIENT'),
        ],
        'level' => env('ROLLBAR_LEVEL'),
    ],
];
