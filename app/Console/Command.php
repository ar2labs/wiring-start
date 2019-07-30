<?php

namespace Console;

use Psr\Container\ContainerInterface;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wiring\Interfaces\DatabaseInterface;

/**
 * Class Command
 *
 * @package Console
 */
abstract class Command extends SymfonyCommand
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var \Symfony\Component\Console\Input\InputInterface
     */
    private $input;

    /**
     * @var \Symfony\Component\Console\Output\OutputInterface
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
     * Load database settings.
     */
    protected function database()
    {
        // Capsule aims to make configuring the library for usage outside of the
        // Laravel framework as easy as possible.
        if (env('DB_CONNECTION') === 'eloquent') {
            $this->container->get(DatabaseInterface::class)->bootEloquent();
        }
    }

    /**
     * Command settings.
     */
    protected function configure()
    {
        $this->setName($this->command)->setDescription($this->getDescription());
        $this->addArguments();
        $this->addOptions();
    }

    /**
     * Command execute.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return mixed
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->input = $input;
        $this->output = $output;

        return $this->handle($input, $output);
    }

    /**
     * Set arguments.
     *
     * @param $name
     * @return mixed
     */
    protected function argument($name)
    {
        return $this->input->getArgument($name);
    }

    /**
     * Set option.
     *
     * @param $name
     * @return mixed
     */
    protected function option($name)
    {
        return $this->input->getOption($name);
    }

    /**
     * Add arguments.
     */
    protected function addArguments()
    {
        foreach ($this->arguments() as $argument) {
            $this->addArgument($argument[0], $argument[1], $argument[2]);
        }
    }

    /**
     * Add options.
     */
    protected function addOptions()
    {
        foreach ($this->options() as $option) {
            $this->addOption($option[0], $option[1], $option[2], $option[3], $option[4]);
        }
    }

    /**
     * Show notification.
     *
     * @param $value
     * @return mixed
     */
    protected function info($value)
    {
        return $this->output->writeln('<info>' . $value . '</info>');
    }

    /**
     * Show comment.
     *
     * @param $value
     * @return mixed
     */
    protected function comment($value)
    {
        return $this->output->writeln('<comment>' . $value . '</comment>');
    }

    /**
     * Show error.
     *
     * @param $value
     * @return mixed
     */
    protected function error($value)
    {
        return $this->output->writeln('<error>' . $value . '</error>');
    }
}
