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
    public function asset(string $name = ''): string
    {
        $appUrl = env('APP_URL', '');
        $appUrl = is_string($appUrl) ? rtrim($appUrl, '/') : '';

        return $appUrl . '/' . ltrim($name, '/');
    }

    /**
     * Get base url.
     *
     * @param  string $name
     *
     * @return string
     */
    public function path(string $name = ''): string
    {
        $serverName = $_SERVER['SERVER_NAME'] ?? 'localhost';
        $defaultUrl = 'http://' . (is_string($serverName) ? $serverName : 'localhost');
        $appUrl = env('APP_URL', $defaultUrl);
        $appUrl = is_string($appUrl) ? rtrim($appUrl, '/') : $defaultUrl;

        return $appUrl . '/' . ltrim($name, '/');
    }

    /**
     * Get dotenv paramaters.
     *
     * @param string $key
     * @return mixed
     */
    public function env(string $key, mixed $default = null): mixed
    {
        return env($key, $default);
    }
}
