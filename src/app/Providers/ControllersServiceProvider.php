<?php

namespace App\Providers;

use App\Controllers\AboutController;
use App\Controllers\EventController;
use App\Controllers\HomeController;
use App\Controllers\UserController;
use App\Services\EventService;
use App\Services\UserService;
use Psr\Container\ContainerInterface;

class ControllersServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container[HomeController::class] = function (ContainerInterface $container) {
            $twig = $container->get('view');
            return new HomeController($twig);
        };

        $this->container[UserController::class] = function (ContainerInterface $container) {
            $twig = $container->get('view');
            $userService = $container->get(UserService::class);
            return new UserController($twig, $userService);
        };

        $this->container[AboutController::class] = function (ContainerInterface $container) {
            $twig = $container->get('view');
            return new AboutController($twig);
        };

        $this->container[EventController::class] = function (ContainerInterface $container) {
            $eventService = $container->get(EventService::class);
            return new EventController($eventService);
        };
    }
}
