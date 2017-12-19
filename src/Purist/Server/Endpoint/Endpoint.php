<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Resource;

interface Endpoint extends Resource
{
    public function match(ServerRequestInterface $request): bool;
}
