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

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'mailchimp' => [
        'domain' => env('MAILCHIMP_DOMAIN', false),
        'user' => env('MAILCHIMP_USER', false),
        'secret' => env('MAILCHIMP_SECRET', false),
        'listId' => env('MAILCHIMP_LISTID', false),
    ],

    'recaptcha' => [
        'url' => env('RECAPTCHA_URL', false),
        'sitekey' => env('RECAPTCHA_SITEKEY', false),
        'secretkey' => env('RECAPTCHA_SECRETKEY', false),
    ],

    'facebook' => [
        'domain' => env('FACEBOOK_URL', false),
        'appid' => env('FACEBOOK_APPID', false),
        'secret' => env('FACEBOOK_SECRET', false),
        'client' => env('FACEBOOK_CLIENTTOKEN', false),
    ]
];
