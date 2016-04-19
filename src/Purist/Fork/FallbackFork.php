<?php

namespace Purist\Fork;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\HttpCall;

class FallbackFork implements Fork
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @param RequestInterface $request
     * @return Optional
     */
    public function route(RequestInterface $request)
    {
        return new Response(
            $this->endpoint->response($request)
        );
    }
}
