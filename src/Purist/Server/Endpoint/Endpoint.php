<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

interface Endpoint extends RequestHandlerInterface
{
    public function match(ServerRequestInterface $request): bool;
}
