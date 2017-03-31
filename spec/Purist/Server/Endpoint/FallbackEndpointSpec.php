<?php

namespace spec\Purist\Server\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
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

    function it_will_always_match_request(RequestInterface $request)
    {
        $this->match($request)->shouldReturn(true);
    }

    function it_will_return_resource_from_request(RequestInterface $request, $resource)
    {
        $this->resource($request)->shouldReturn($resource);
    }
}
