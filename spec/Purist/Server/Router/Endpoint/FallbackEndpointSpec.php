<?php

namespace spec\Purist\Server\Router\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint;
use Purist\Server\Router\Endpoint\FallbackEndpoint;

class FallbackEndpointSpec extends ObjectBehavior
{
    function let(ServerRequestInterface $resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FallbackEndpoint::class);
        $this->shouldImplement(\Purist\Server\Router\Endpoint::class);
    }

    function it_will_always_match_request(ServerRequestInterface $request)
    {
        $this->match($request)->shouldReturn(true);
    }

    function it_will_return_resource_from_request(ServerRequestInterface $request, RequestHandlerInterface $resource, ResponseInterface $response)
    {
        $resource->handle($request)->willReturn($response);
        $this->handle($request)->shouldReturn($response);
    }
}
