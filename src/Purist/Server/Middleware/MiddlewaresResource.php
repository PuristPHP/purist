<?php
declare(strict_types=1);

namespace Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Resource;

final class MiddlewaresResource implements Resource
{
    private $middlewares;

    public function __construct(Middleware ...$middlewares)
    {
        $this->middlewares = $middlewares;
    }

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return (new OrderedMiddlewares(...$this->middlewares))->handle($request);
    }
}
