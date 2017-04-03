<?php

declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;

final class FallbackEndpoint implements Endpoint
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function match(RequestInterface $request): bool
    {
        return true;
    }

    public function resource(): Resource
    {
        return $this->resource;
    }
}