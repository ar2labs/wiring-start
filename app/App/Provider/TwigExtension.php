<?php

declare(strict_types=1);

namespace App\Provider;

use Psr\Container\ContainerInterface;

class TwigExtension extends \Twig_Extension
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
     * @return array
     */
    public function getFunctions(): array
    {
        return [
            new \Twig_SimpleFunction('asset', [$this, 'asset']),
            new \Twig_SimpleFunction('env', [$this, 'env']),
            new \Twig_SimpleFunction('getenv', [$this, 'env']),
            new \Twig_SimpleFunction('base_url', [$this, 'path']),
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
     * @return array|false|null|string
     */
    public function env(string $key, string $default = null)
    {
        return env($key, $default);
    }
}
