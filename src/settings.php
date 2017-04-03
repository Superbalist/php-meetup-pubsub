<?php

// define app settings here
return [
    'redis' => [
        'scheme' => 'tcp',
        'host' => 'php-meetup-pubsub-redis',
        'port' => 6379,
        'database' => 0,
        'read_write_timeout' => 0,
    ],
    'providers' => [
        \App\Providers\CommandsServiceProvider::class,
        \App\Providers\ControllersServiceProvider::class,
        \App\Providers\PubSubServiceProvider::class,
        \App\Providers\ServicesServiceProvider::class,
        \App\Providers\SessionServiceProvider::class,
        \App\Providers\ValidationServiceProvider::class,
        \App\Providers\ViewServiceProvider::class,
    ],
    'event_mappings' => [
        'click' => 'http://php-meetup-pubsub.dev/schemas/events/browser/click/1.0.json',
    ],
];
