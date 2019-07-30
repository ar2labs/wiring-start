<?php

namespace App\Http\Middleware;

use Psr\Http\Message\{ResponseInterface, ServerRequestInterface};
use Psr\Http\Server\{RequestHandlerInterface, MiddlewareInterface};
use Psr\Container\ContainerInterface;
use Wiring\Traits\ContainerAwareTrait;

abstract class AbstractMiddleware implements MiddlewareInterface
{
    use ContainerAwareTrait;

    /**
     * Middleware constructor.
     *
     * @param ContainerInterface $container
     */
    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
    }

    /**
     * Process an incoming server request and return a response,
     * optionally delegating response creation to a handler.
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
        // Invoke the rest of the middleware stack and your
        // controller resulting in a returned response object
        $response = $handler->handle($request);

        return $response;
    }
}
