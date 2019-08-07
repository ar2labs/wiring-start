<?php

declare(strict_types=1);

namespace Console\Commands;

use Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class ServeCommand extends Command
{
    /**
     * Configure the console command.
     */
    protected function configure()
    {
        $desc = 'Serve the application on the PHP development server';

        $this
            ->setName('serve')
            ->setDescription($desc)
            ->addOption(
                'host',
                null,
                InputOption::VALUE_OPTIONAL,
                'The host address to serve the application on',
                'localhost'
            )
            ->addOption(
                'port',
                null,
                InputOption::VALUE_OPTIONAL,
                'The port to serve the application on',
                8000
            );
    }

    /**
     * Execute the console command.
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->checkPhpVersion();

        chdir(ROOT_PATH);

        $host = $input->getOption('host');
        $port = $input->getOption('port');

        $mesg = '<info>PHP built-in Web Server started on' .
            "</info> <comment>http://{$host}:{$port}</comment>";

        $output->writeln($mesg);

        $public = ROOT_PATH . '/public';

        passthru('"' . PHP_BINARY . '"' .
            " -S {$host}:{$port} -t \"{$public}\"");
    }

    /**
     * Check the current PHP version is >= 5.4.
     *
     * @return void
     *
     * @throws \Exception
     */
    protected function checkPhpVersion()
    {
        if (version_compare(PHP_VERSION, '7.1.0', '<')) {
            $mesg = 'This PHP binary is not version 7.1 or greater.';

            throw new \Exception($mesg);
        }
    }
}
