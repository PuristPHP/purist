<?php
declare(strict_types=1);

namespace Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Response\TextResponse;

final class OrderedMiddlewares implements Middlewares
{
    private $middlewares;

    public function __construct(Middleware ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (count($this->middlewares) === 0) {
            return new TextResponse('Not Found', 404);
        }

        return $this->middlewares[0]->handle(
            $request,
            new self(
                ...array_slice($this->middlewares, 1, 1)
            )
        );
    }
}
