<?php

namespace Purist\Server;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Exception;

interface Resource
{
    /**
     * @throws Exception
     */
    public function response(RequestInterface $request): ResponseInterface;
}
