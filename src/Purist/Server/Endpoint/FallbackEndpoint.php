<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Resource;

final class FallbackEndpoint implements Endpoint
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function match(ServerRequestInterface $request): bool
    {
        return true;
    }

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return $this->resource->response($request);
    }
}
