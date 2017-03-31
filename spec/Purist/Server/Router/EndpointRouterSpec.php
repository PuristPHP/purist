<?php

namespace spec\Purist\Server\Router;

use Exception;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Resource;

class EndpointRouterSpec extends ObjectBehavior
{
    function let(
        RequestInterface $request,
        Resource $resource1,
        Resource $resource2,
        Endpoint $endpoint1,
        Endpoint $endpoint2
    )
    {
        $endpoint1->resource($request)->willReturn($resource1);
        $endpoint2->resource($request)->willReturn($resource2);

        $this->beConstructedWith($endpoint1, $endpoint2);
    }

    function it_returns_a_matched_endpoint_response($request, $resource1, $endpoint1, $endpoint2)
    {
        $endpoint1->match($request)->willReturn(true);
        $endpoint2->match($request)->willReturn(false);

        $this->route($request)->shouldReturn($resource1);
    }

    function it_will_throw_exception_when_nothing_matches($request, $endpoint1, $endpoint2) {
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(false);

        $this->shouldThrow(Exception::class)->duringRoute($request);
    }
}
