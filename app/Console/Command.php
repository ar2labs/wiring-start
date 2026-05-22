<?php

declare(strict_types=1);

namespace Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wiring\Traits\ContainerAwareTrait;

/**
 * Class Command
 *
 * @package Console
 */
abstract class Command extends SymfonyCommand
{
    use ContainerAwareTrait;

    private ?InputInterface $input = null;

    private ?OutputInterface $output = null;

    /**
     * Command constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->setContainer($container);
    }

    protected function initialize(InputInterface $input, OutputInterface $output): void
    {
        $this->input = $input;
        $this->output = $output;
    }

    /**
     * Set arguments.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function argument(string $name): mixed
    {
        return $this->input?->getArgument($name);
    }

    /**
     * Set option.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function option(string $name): mixed
    {
        return $this->input?->getOption($name);
    }

    /**
     * Show notification.
     *
     * @param string $message
     *
     * @return void
     */
    protected function info(string $message): void
    {
        $this->output?->writeln('<info>' . $message . '</info>');
    }

    /**
     * Show comment.
     *
     * @param string $message
     *
     * @return void
     */
    protected function comment(string $message): void
    {
        $this->output?->writeln('<comment>' . $message . '</comment>');
    }

    /**
     * Show error.
     *
     * @param string $message
     *
     * @return void
     */
    protected function error(string $message): void
    {
        $this->output?->writeln('<error>' . $message . '</error>');
    }
}
