<?php

declare(strict_types=1);

namespace Console;

use Console\Commands\ServeCommand;

class Kernel
{
    /**
     * @var list<class-string<\Symfony\Component\Console\Command\Command>>
     */
    protected $commands = [];

    /**
     * @var list<class-string<Command>>
     */
    protected $defaultCommands = [
        ServeCommand::class,
    ];

    /**
     * Get commands array.
     *
     * @return list<class-string<\Symfony\Component\Console\Command\Command>>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Get default commands array.
     *
     * @return list<class-string<Command>>
     */
    public function getDefaultCommands(): array
    {
        return $this->defaultCommands;
    }
}
