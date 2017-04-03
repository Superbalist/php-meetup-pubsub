<?php

namespace App\Providers;

use App\Services\EventService;
use App\Services\UserService;
use Psr\Container\ContainerInterface;
use Superbalist\EventPubSub\EventManager;

class ServicesServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container[UserService::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            return new UserService($events);
        };

        $this->container[EventService::class] = function (ContainerInterface $container) {
            $events = $container->get(EventManager::class);
            $mappings = $container->get('settings')['event_mappings'];
            return new EventService($events, $mappings);
        };
    }
}
