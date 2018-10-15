<?php

declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Server\MiddlewareInterface;

final class MiddlewareServer extends DefaultServer
{
    public function __construct(MiddlewareInterface ...$middlewares)
    {
        parent::__construct(
            new Middlewares(
                ...$middlewares
            )
        );
    }
}
