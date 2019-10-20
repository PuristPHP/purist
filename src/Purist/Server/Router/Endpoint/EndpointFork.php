<?php

declare(strict_types=1);

namespace Purist\Server\Router\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\Router\Endpoint;

final class EndpointFork implements RequestHandlerInterface
{
    private $endpoints;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        foreach ($this->endpoints as $endpoint) {
            if (!$endpoint->match($request)) {
                continue;
            }

            return $endpoint->handle($request);
        }

        return new TextResponse('Not Found', 404);
    }
}
