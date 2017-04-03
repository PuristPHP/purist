<?php

declare(strict_types=1);

namespace Acme;

use Purist\Application;
use Purist\Server\Router\EndpointRouter;
use Purist\Server\Endpoint\PathEndpoint;
use Purist\Server\Router\Router;

class AcmeApplication implements Application
{
    public function run(): Router
    {
        return new EndpointRouter(
            new PathEndpoint('/test', new HelloPage())
        );
    }
}
