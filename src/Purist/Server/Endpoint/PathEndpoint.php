<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Resource;

final class PathEndpoint implements Endpoint
{
    private $path;
    private $resource;

    public function __construct(string $path, Resource $resource)
    {
        $this->path = $path;
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return $this->path === $request->getUri()->getPath();
    }

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->response($request);
    }
}
