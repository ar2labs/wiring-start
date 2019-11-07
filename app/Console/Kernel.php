<?php

declare(strict_types=1);

namespace Console;

use Console\Commands\ServeCommand;

class Kernel
{
    /**
     * @var array
     */
    protected $commands = [];

    /**
     * @var array
     */
    protected $defaultCommands = [
        ServeCommand::class,
    ];

    /**
     * Get commands array.
     *
     * @return array
     */
    public function getCommands(): array
    {
        return $this->commands;
    }

    /**
     * Get default commands array.
     *
     * @return array
     */
    public function getDefaultCommands(): array
    {
        return $this->defaultCommands;
    }
}
