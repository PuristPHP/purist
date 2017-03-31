<?php

namespace Purist\Server\Router;

use Psr\Http\Message\RequestInterface;
use Exception;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Router\Router;

final class EndpointRouter implements Router
{
    private $endpoints;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    public function route(RequestInterface $request): Resource
    {
        foreach ($this->endpoints as $endpoint) {
            if (!$endpoint->match($request)) {
                continue;
            }

            return $endpoint->resource();
        }

        throw new Exception('No matching endpoint could be found.');
    }
}
