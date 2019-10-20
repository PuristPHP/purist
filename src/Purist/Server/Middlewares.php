<?php

declare(strict_types=1);

namespace Purist\Server;

use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class Middlewares implements RequestHandlerInterface
{
    private $middlewares;

    public function __construct(MiddlewareInterface ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    /**
     * @throws Exception
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        if (count($this->middlewares) === 0) {
            throw new Exception('Tried to call next middleware but there was none.');
        }

        return $this->middlewares[0]->process(
            $request,
            new self(
                ...array_slice($this->middlewares, 1, 1)
            )
        );
    }
}
