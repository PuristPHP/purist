<?php

namespace spec\Purist\Server\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\FallbackEndpoint;

class FallbackEndpointSpec extends ObjectBehavior
{
    function let(ServerRequestInterface $resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(FallbackEndpoint::class);
        $this->shouldImplement(Endpoint::class);
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
