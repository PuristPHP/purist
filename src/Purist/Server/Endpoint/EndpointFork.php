<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Response\TextResponse;

final class EndpointFork implements Endpoint
{
    private $endpoints;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    public function match(ServerRequestInterface $request): bool
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($request)) {
                return true;
            }
        }

        return false;
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
