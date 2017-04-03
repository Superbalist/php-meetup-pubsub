<?php

require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../app.php';
/** @var \Slim\App $app */

$app->run();
