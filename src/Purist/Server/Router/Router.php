<?php

namespace Purist\Server\Router;

use Psr\Http\Message\RequestInterface;

interface Router
{
    public function route(RequestInterface $request): Resource;
}
