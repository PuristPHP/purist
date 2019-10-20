<?php

declare(strict_types=1);

namespace Purist\Server\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface ResponseEndpoint extends RequestHandlerInterface
{
    public function match(ResponseInterface $response): bool;
}
