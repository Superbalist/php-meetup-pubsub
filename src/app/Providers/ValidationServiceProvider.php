<?php

namespace App\Providers;

use App\Middleware\ValidationErrorRedirectMiddleware;
use DavidePastore\Slim\Validation\Validation;
use Psr\Container\ContainerInterface;
use Respect\Validation\Validator as v;

class ValidationServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container[ValidationErrorRedirectMiddleware::class] = function (ContainerInterface $container) {
            $flash = $container->get('flash');
            return new ValidationErrorRedirectMiddleware($flash);
        };

        $this->container['SignUpValidator'] = function () {
            $rules = [
                'email' => v::email(),
                'first_name' => v::notEmpty(),
                'password' => v::notEmpty()->length(6),
            ];
            return new Validation($rules);
        };

        $this->container['LoginValidator'] = function () {
            $rules = [
                'email' => v::email(),
                'password' => v::notEmpty(),
            ];
            return new Validation($rules);
        };
    }
}
