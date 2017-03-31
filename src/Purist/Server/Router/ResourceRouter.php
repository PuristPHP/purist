<?php

namespace Purist\Server\Router;

use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;
use Purist\Server\Router\Router;

class ResourceRouter implements Router
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function route(RequestInterface $request): Resource
    {
        return $this->resource;
    }
}
