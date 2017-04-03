<?php

declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;

final class PathEndpoint implements Endpoint
{
    private $path;
    private $resource;

    public function __construct(string $path, Resource $endpoint)
    {
        $this->path = $path;
        $this->resource = $endpoint;
    }

    public function match(RequestInterface $request): bool
    {
        return $this->path === $request->getUri()->getPath();
    }

    public function resource(): Resource
    {
        return $this->resource;
    }
}
