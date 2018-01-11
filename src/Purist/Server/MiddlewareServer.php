<?php

namespace Purist\Server;

use Purist\Server\Middleware\Middleware;
use Purist\Server\Middleware\MiddlewaresResource;

final class MiddlewareServer extends ResourceServer
{
    public function __construct(Middleware ...$middlewares)
    {
        parent::__construct(
            new MiddlewaresResource(
                ...$middlewares
            )
        );
    }
}
