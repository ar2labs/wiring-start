<?php

namespace Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class Command
 *
 * @package Console
 */
abstract class Command extends SymfonyCommand
{
    /**
     * @var ContainerInterface $container
     */
    protected $container;

    /**
     * @var InputInterface $input
     */
    private $input;

    /**
     * @var OutputInterface $output
     */
    private $output;

    /**
     * Command constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        parent::__construct();

        $this->container = $container;
    }

    /**
     * Set arguments.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function argument(string $name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * Set option.
     *
     * @param string $name
     *
     * @return mixed
     */
    protected function option(string $name)
    {
        return $this->input->getOption($name);
    }

    /**
     * Show notification.
     *
     * @param string $message
     *
     * @return mixed
     */
    protected function info(string $message)
    {
        return $this->output->writeln('<info>' . $message . '</info>');
    }

    /**
     * Show comment.
     *
     * @param string $message
     *
     * @return mixed
     */
    protected function comment(string $message)
    {
        return $this->output->writeln('<comment>' . $message . '</comment>');
    }

    /**
     * Show error.
     *
     * @param string $message
     *
     * @return mixed
     */
    protected function error(string $message)
    {
        return $this->output->writeln('<error>' . $message . '</error>');
    }
}
