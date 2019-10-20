<?php

namespace spec\Purist\Server\Router\ResponseEndpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\ResponseEndpoint;
use Purist\Server\Router\ResponseEndpoint\StatusCodeEndpoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class StatusCodeEndpointSpec extends ObjectBehavior
{
    function let(RequestHandlerInterface $handler)
    {
        $this->beConstructedWith(404, $handler);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(StatusCodeEndpoint::class);
        $this->shouldImplement(ResponseEndpoint::class);
    }

    function it_matches_on_status_code(
        ResponseInterface $response
    ) {
        $response->getStatusCode()->willReturn(404);
        $this->match($response)->shouldReturn(true);

        $response->getStatusCode()->willReturn(200);
        $this->match($response)->shouldReturn(false);
    }

    function it_returns_the_request_handler_response(
        RequestHandlerInterface $handler,
        ResponseInterface $response,
        ServerRequestInterface $request
    ) {
        $handler->handle($request)->willReturn($response);
        $this->handle($request)->shouldReturn($response);
    }
}
