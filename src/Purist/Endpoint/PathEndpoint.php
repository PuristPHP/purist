<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Endpoint\Response\EmptyResponse;
use Purist\Endpoint\Response\Response;

final class PathEndpoint implements Endpoint
{
    private $path;
    private $endpoint;

    public function __construct(string $path, Endpoint $endpoint)
    {
        $this->path = $path;
        $this->endpoint = $endpoint;
    }

    public function response(RequestInterface $request): ResponseInterface
    {
        if ($this->path !== $request->getUri()->getPath()) {
            return new EmptyResponse;
        }

        return new Response($this->endpoint->response($request));
    }
}
