<?php

declare(strict_types=1);

namespace App\Provider;

use Psr\Container\ContainerInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class TwigExtension extends AbstractExtension
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * Get name.
     *
     * @return string
     */
    public function getName(): string
    {
        return 'app';
    }

    /**
     * Get functions.
     *
     * @return array<TwigFunction>
     */
    public function getFunctions(): array
    {
        return [
            new TwigFunction('asset', [$this, 'asset']),
            new TwigFunction('env', [$this, 'env']),
            new TwigFunction('getenv', [$this, 'env']),
            new TwigFunction('base_url', [$this, 'path']),
        ];
    }

    /**
     * Get assets url.
     *
     * @param  string $name
     *
     * @return string
     */
    public function asset($name = ''): string
    {
        return env('APP_URL') . '/' . $name;
    }

    /**
     * Get base url.
     *
     * @param  string $name
     *
     * @return string
     */
    public function path($name = ''): string
    {
        return env('APP_URL', 'http://' . $_SERVER['SERVER_NAME']) . $name;
    }

    /**
     * Get dotenv paramaters.
     *
     * @param string $key
     * @param string|null $default
     *
     * @return array<string>|false|null|string
     */
    public function env(string $key, string $default = null)
    {
        return env($key, $default);
    }
}
