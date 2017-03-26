<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Endpoint\Optional;
use Purist\HttpCall;

class FallbackEndpoint implements Endpoint
{
    /**
     * @var Endpoint
     */
    private $endpoint;

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    public function response(RequestInterface $request): ResponseInterface
    {
        return new Response(
            $this->endpoint->response($request)
        );
    }
}
