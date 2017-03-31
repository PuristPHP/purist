<?php

namespace Purist;

use Purist\Server\Endpoint\Resource;
use Purist\Server\Router\Router;
use Purist\Server\Router\ResourceRouter;

final class ResourceApplication implements Application
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function run(): Router
    {
        return new ResourceRouter($this->resource);
    }
}
