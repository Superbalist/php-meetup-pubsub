<?php

use App\Controllers\AboutController;
use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Middleware\ValidationErrorRedirectMiddleware;

// register routes
$app->get('/', HomeController::class . ':home')
    ->setName('home');

$app->get('/signup', UserController::class . ':signup')
    ->setName('signup');

$app->post('/signup', UserController::class . ':postSignup')
    ->setName('post.signup')
    ->add($container->get(ValidationErrorRedirectMiddleware::class))
    ->add($container->get('SignUpValidator'));

$app->get('/login', UserController::class . ':login')
    ->setName('login');

$app->post('/login', UserController::class . ':postLogin')
    ->setName('post.login')
    ->add($container->get(ValidationErrorRedirectMiddleware::class))
    ->add($container->get('LoginValidator'));

$app->get('/about', AboutController::class . ':about')
    ->setName('about');

$app->post('/events/emit', EventController::class . ':postEmit')
    ->setName('events/emit');
