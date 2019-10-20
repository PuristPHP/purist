<?php

declare(strict_types=1);

namespace Purist\Server\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint\EndpointFork;

final class RouterMiddleware implements MiddlewareInterface
{
    private $requestHandler;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->requestHandler = new EndpointFork(...$endpoints);
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        return $this->requestHandler->handle($request);
    }
}
