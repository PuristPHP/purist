<?php
declare(strict_types=1);

namespace Purist\Server\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

final class ResponseRouterMiddleware implements MiddlewareInterface
{
    private $routedResponses;

    public function __construct(ResponseEndpoint ...$routedResponses)
    {
        $this->routedResponses = $routedResponses;
    }

    public function process(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler
    ): ResponseInterface {
        $response = $handler->handle($request);

        foreach ($this->routedResponses as $routedResponse) {
            if (!$routedResponse->match($response)) {
                continue;
            }

            return $routedResponse->handle($request);
        }

        return $response;
    }
}
