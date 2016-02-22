<?php

namespace Purist\Endpoints;

use Psr\Http\Message\RequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;

final class MatchingEndpoint
{
    private $endpoints;

    /**
     * MatchingEndpoint constructor.
     * @param Endpoint[] ...$endpoints
     */
    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function response(RequestInterface $request)
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($request)) {
                return $endpoint->response($request);
            }
        }

        throw new Exception('No matching endpoint could be found.');
    }

    public function match(RequestInterface $request)
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($request)) {
                return true;
            }
        }

        return false;
    }
}
