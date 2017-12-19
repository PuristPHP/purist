<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Resource;

final class MethodEndpoint implements Endpoint
{
    private $method;
    private $resource;

    public function __construct(string $method, Resource $resource)
    {
        $this->method = $method;
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return mb_strtoupper($request->getMethod()) === mb_strtoupper($this->method);
    }

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->response($request);
    }
}
