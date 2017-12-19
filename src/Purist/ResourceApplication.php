<?php

declare(strict_types=1);

namespace Purist;

use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\FallbackEndpoint;
use Purist\Server\Resource;

final class ResourceApplication implements Application
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    public function run(): Endpoint
    {
        return new FallbackEndpoint($this->resource);
    }
}
