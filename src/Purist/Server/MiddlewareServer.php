<?php

namespace Purist\Server;

use Psr\Http\Server\MiddlewareInterface;
use Purist\Server\Middleware\MiddlewaresResource;

final class MiddlewareServer extends ResourceServer
{
    public function __construct(MiddlewareInterface ...$middlewares)
    {
        parent::__construct(
            new MiddlewaresResource(
                ...$middlewares
            )
        );
    }
}
