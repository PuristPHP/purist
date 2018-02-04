<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class PathEndpoint implements Endpoint
{
    private $path;
    private $resource;

    public function __construct(string $path, RequestHandlerInterface $resource)
    {
        $this->path = $path;
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return $this->path === $request->getUri()->getPath();
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->handle($request);
    }
}
