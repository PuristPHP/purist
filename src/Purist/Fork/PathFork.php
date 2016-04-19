<?php

namespace Purist\Fork;

use Psr\Http\Message\RequestInterface;
use Purist\Fork\Response\EmptyResponse;
use Purist\Fork\Response\Optional;
use Purist\Fork\Response\Response;
use Purist\Endpoint;

final class PathFork implements Fork
{
    private $path;
    private $endpoint;

    /**
     * @param $path
     * @param Endpoint $endpoint
     */
    public function __construct($path, Endpoint $endpoint)
    {
        $this->path = $path;
        $this->endpoint = $endpoint;
    }

    /**
     * @param RequestInterface $request
     * @return Optional
     */
    public function route(RequestInterface $request)
    {
        if ($this->path !== $request->getUri()->getPath()) {
            return new EmptyResponse;
        }

        return new Response($this->endpoint->response($request));
    }
}
