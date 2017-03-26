<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;

final class MatchingEndpoint implements Endpoint
{
    private $endpoints;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    public function response(RequestInterface $request): ResponseInterface
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->response($request)->has()) {
                return $endpoint->response($request)->get();
            }
        }

        throw new Exception('No matching fork could be found.');
    }
}
