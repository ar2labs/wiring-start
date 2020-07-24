<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SessionMiddleware implements MiddlewareInterface
{
    /**
     * @var array<string, bool|int|string|null>
     */
    protected $options = [
        'name' => 'wiring',
        'lifetime' => 7200,
        'path' => null,
        'domain' => null,
        'secure' => false,
        'httponly' => true,
        'cache_limiter' => 'nocache',
    ];

    /**
     * Session middleware constructor.
     *
     * @param array<string> $options
     */
    public function __construct($options = [])
    {
        $keys = array_keys($this->options);

        foreach ($keys as $key) {
            if (array_key_exists($key, $options)) {
                $this->options[$key] = $options[$key];
            }
        }

        if (session_status() !== PHP_SESSION_ACTIVE) {
            $options = $this->options;
            $current = session_get_cookie_params();

            $lifetime = (int) ($options['lifetime'] ?: $current['lifetime']);
            $path = $options['path'] ?: $current['path'];
            $domain = $options['domain'] ?: $current['domain'];
            $secure = (bool) $options['secure'];
            $httponly = (bool) $options['httponly'];

            session_set_cookie_params(
                $lifetime,
                $path,
                $domain,
                $secure,
                $httponly
            );

            session_name((string) $options['name']);
            session_cache_limiter((string) $options['cache_limiter']);
            session_start();
        }
    }

    /**
     * Process an session request and return a response.
     *
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $handler->handle($request);
    }
}
