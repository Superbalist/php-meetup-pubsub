<?php

namespace App\Providers;

use Slim\Flash\Messages;

class SessionServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        session_start();

        $this->container['flash'] = function () {
            return new Messages();
        };
    }
}
