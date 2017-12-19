<?php

namespace spec\Purist\Server\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\UriInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\PathEndpoint;
use Purist\Server\Resource;

class PathEndpointSpec extends ObjectBehavior
{
    function let(Resource $resource)
    {
        $this->beConstructedWith('/hello-world', $resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PathEndpoint::class);
        $this->shouldImplement(Endpoint::class);
    }

    function it_matches_a_path_by_string(ServerRequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);

        $this->match($request)->shouldReturn(true);
    }

    function it_will_not_match_the_wrong_path(ServerRequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-worldo');
        $request->getUri()->willReturn($uri);

        $this->match($request)->shouldReturn(false);
    }

    function it_will_return_a_resource_from_request($resource, ServerRequestInterface $request, UriInterface $uri, ResponseInterface $response)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);
        $resource->response($request)->willReturn($response);

        $this->response($request)->shouldReturn($response);
    }
}
