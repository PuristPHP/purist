<?php

namespace spec\Purist\Server\Router\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint;
use Purist\Server\Router\Endpoint\MethodEndpoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MethodEndpointSpec extends ObjectBehavior
{
    function let(RequestHandlerInterface $resource)
    {
        $this->beConstructedWith('POST', $resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MethodEndpoint::class);
        $this->shouldImplement(Endpoint::class);
    }

    function it_matches_against_http_methods(ServerRequestInterface $request)
    {
        $request->getMethod()->willReturn('POST');
        $this->match($request)->shouldReturn(true);

        $request->getMethod()->willReturn('GET');
        $this->match($request)->shouldReturn(false);
    }

    function it_returns_response_from_resource(
        ServerRequestInterface $request,
        ResponseInterface $response,
        RequestHandlerInterface $resource
    ) {
        $resource->handle($request)->willReturn($response);
        $this->handle($request)->shouldReturn($response);
    }
}
