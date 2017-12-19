<?php

namespace spec\Purist\Server\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\FallbackEndpoint;
use Purist\Server\Resource;

class FallbackEndpointSpec extends ObjectBehavior
{
    function let(Resource $resource)
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

    function it_will_return_resource_from_request(ServerRequestInterface $request, Resource $resource, ResponseInterface $response)
    {
        $resource->response($request)->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }
}
