<?php

use Slim\App;

// create new application
$settings = require_once __DIR__ . '/settings.php';
$app = new App(['settings' => $settings]);

// register dependencies via service providers
$container = $app->getContainer();

foreach ($settings['providers'] as $class) {
    $provider = new $class($container); /** @var \App\Providers\ServiceProviderInterface $provider */
    $provider->register();
}

require_once __DIR__ . '/routes.php';

return $app;
