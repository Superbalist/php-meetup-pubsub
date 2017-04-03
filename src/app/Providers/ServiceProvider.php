<?php

namespace App\Providers;

use Psr\Container\ContainerInterface;

abstract class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }
}
