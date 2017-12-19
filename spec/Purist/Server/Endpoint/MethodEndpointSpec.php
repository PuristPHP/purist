<?php

namespace spec\Purist\Server\Endpoint;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\MethodEndpoint;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Resource;

class MethodEndpointSpec extends ObjectBehavior
{
    function let(Resource $resource)
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
        Resource $resource
    ) {
        $resource->response($request)->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }
}
