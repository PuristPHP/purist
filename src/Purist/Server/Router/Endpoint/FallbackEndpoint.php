<?php

declare(strict_types=1);

namespace Purist\Server\Router\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Router\Endpoint;

final class FallbackEndpoint implements Endpoint
{
    private $resource;

    public function __construct(ServerRequestInterface $resource)
    {
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return true;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->handle($request);
    }
}
