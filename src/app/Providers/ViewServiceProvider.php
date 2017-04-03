<?php

namespace App\Providers;

use Knlv\Slim\Views\TwigMessages;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\RequestInterface;
use Slim\Views\Twig;
use Slim\Views\TwigExtension;
use Twig_Extension_Debug;

class ViewServiceProvider extends ServiceProvider
{
    /**
     * Register a service provider.
     */
    public function register()
    {
        $this->container['view'] = function (ContainerInterface $container) {
            $dir = realpath(__DIR__ . '/../../');

            $view = new Twig($dir . '/views', [
                // TODO: enable cache
                //'cache' => $dir . '/cache',
                'debug' => true,
            ]);

            $request = $container->get('request'); /** @var RequestInterface $request */
            $basePath = rtrim(str_ireplace('index.php', '', $request->getUri()->getBasePath()), '/');
            $view->addExtension(new TwigExtension($container['router'], $basePath));

            $flash = $container->get('flash');
            $view->addExtension(new TwigMessages($flash));

            $view->addExtension(new Twig_Extension_Debug());

            return $view;
        };
    }
}
