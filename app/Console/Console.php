<?php

namespace Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class Console extends Application
{
    /**
     * @var \Psr\Container\ContainerInterface
     */
    protected $container;

    /**
     * Console constructor.
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param string $version
     */
    public function __construct(ContainerInterface $container, $name = 'UNKNOWN', $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->container = $container;
    }

    /**
     * Add commands.
     *
     * @param Kernel $kernel
     */
    public function boot(Kernel $kernel)
    {
        foreach ($kernel->getCommands() as $command) {
            $this->add(new $command($this->getContainer()));
        }
    }

    /**
     * Get Slim Framework application.
     *
     * @return \Psr\Container\ContainerInterface
     */
    protected function getContainer()
    {
        return $this->container;
    }
}
