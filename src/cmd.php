<?php

require __DIR__ . '/vendor/autoload.php';

$app = require_once __DIR__ . '/app.php';
/** @var \Slim\App $app */

$container = $app->getContainer();

if (count($argv) === 1) {
    throw new Exception('You must specify a command name to run.');
}

$registry = $container->get(\App\Commands\CommandRegistry::class); /** @var \App\Commands\CommandRegistry $registry */

if (!$registry->has($argv[1])) {
    throw new Exception(sprintf('The command "%s" does not exist.', $argv[1]));
}

$options = array_slice($argv, 2);

$command = $registry->get($argv[1]); /** @var \App\Commands\CommandInterface $command */
$command->run($options);
