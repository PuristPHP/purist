<?php
declare(strict_types=1);

namespace Purist\Server\Router\ResponseEndpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\ResponseEndpoint;

final class StatusCodeEndpoint implements ResponseEndpoint
{
    private $statusCode;
    private $handler;

    public function __construct(int $statusCode, RequestHandlerInterface $handler)
    {
        $this->statusCode = $statusCode;
        $this->handler = $handler;
    }

    public function match(ResponseInterface $response): bool
    {
        return $response->getStatusCode() === $this->statusCode;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return $this->handler->handle($request);
    }
}
