<?php
declare(strict_types=1);

namespace Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;

final class OrderedMiddlewares implements RequestHandlerInterface
{
    private $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (count($this->middlewares) === 0) {
            return new TextResponse('Not Found', 404);
        }

        return $this->middlewares[0]->process(
            $request,
            new self(
                ...array_slice($this->middlewares, 1, 1)
            )
        );
    }
}
