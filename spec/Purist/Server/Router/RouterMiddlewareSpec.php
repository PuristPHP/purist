<?php

namespace spec\Purist\Server\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint;
use Purist\Server\Router\RouterMiddleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RouterMiddlewareSpec extends ObjectBehavior
{
    function let(Endpoint $endpoint)
    {
        $this->beConstructedWith($endpoint);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RouterMiddleware::class);
    }

    function it_returns_response_if_enpoint_is_matching(
        Endpoint $endpoint,
        ServerRequestInterface $request,
        ResponseInterface $response,
        RequestHandlerInterface $middlewares
    ) {
        $endpoint->match($request)->willReturn(true);
        $endpoint->handle($request)->willReturn($response);

        $this->process($request, $middlewares)->shouldReturn($response);
    }

    function it_returns_404_if_endpoints_are_not_matching(
        Endpoint $endpoint,
        ServerRequestInterface $request,
        RequestHandlerInterface $middlewares
    ) {
        $endpoint->match($request)->willReturn(false);
        $endpoint->handle($request)->shouldNotBeCalled();

        $this->process($request, $middlewares)
            ->callOnWrappedObject('getStatusCode')
            ->shouldBe(404);
    }
}
