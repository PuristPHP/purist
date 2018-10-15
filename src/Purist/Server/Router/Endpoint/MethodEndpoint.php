<?php

declare(strict_types=1);

namespace Purist\Server\Router\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint;

final class MethodEndpoint implements Endpoint
{
    private $method;
    private $resource;

    public function __construct(string $method, RequestHandlerInterface $resource)
    {
        $this->method = $method;
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return mb_strtoupper($request->getMethod()) === mb_strtoupper($this->method);
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->handle($request);
    }
}
