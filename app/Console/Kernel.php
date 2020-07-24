<?php

declare(strict_types=1);

namespace Console;

use Console\Commands\ServeCommand;

class Kernel
{
    /**
     * @var array<mixed>
     */
    protected $commands = [];

    /**
     * @var array<mixed>
     */
    protected $defaultCommands = [
        ServeCommand::class,
    ];

    /**
     * Get commands array.
     *
     * @return array<mixed>
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Get default commands array.
     *
     * @return array<mixed>
     */
    public function getDefaultCommands(): array
    {
        return $this->defaultCommands;
    }
}
