<?php

namespace Purist\Endpoints;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Endpoint
{
    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function response(RequestInterface $request);

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request);
}
