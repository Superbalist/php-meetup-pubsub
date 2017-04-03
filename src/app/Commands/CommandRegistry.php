<?php

namespace App\Commands;

use Exception;
use Psr\Container\ContainerInterface;

class CommandRegistry
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var array
     */
    protected $commands = [];

    /**
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @param string $class
     */
    public function register($name, $class)
    {
        $this->commands[$name] = $class;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function has($name)
    {
        return isset($this->commands[$name]);
    }

    /**
     * @param string $name
     * @return CommandInterface
     * @throws Exception
     */
    public function get($name)
    {
        if (!$this->has($name)) {
            throw new Exception(sprintf('The command "%s" is not registered.', $name));
        }
        $class = $this->commands[$name];
        return $this->container->get($class);
    }
}
