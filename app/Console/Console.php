<?php

declare(strict_types=1);

namespace Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Application;

class Console extends Application
{
    protected ContainerInterface $container;

    /**
     * Console constructor.
     *
     * @param ContainerInterface $container
     * @param string $name
     * @param string $version
     */
    public function __construct(ContainerInterface $container, string $name = 'UNKNOWN', string $version = 'UNKNOWN')
    {
        parent::__construct($name, $version);

        $this->container = $container;
    }

    /**
     * Add commands.
     *
     * @param Kernel $kernel
     *
     * @return void
     */
    public function boot(Kernel $kernel): void
    {
        foreach ($kernel->getCommands() as $command) {
            $this->addCommand(new $command());
        }

        foreach ($kernel->getDefaultCommands() as $command) {
            $this->addCommand(new $command($this->container));
        }
    }
}
