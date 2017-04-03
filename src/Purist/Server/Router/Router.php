<?php

declare(strict_types=1);

namespace Purist\Server\Router;

use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;

interface Router
{
    public function route(RequestInterface $request): Resource;
}
