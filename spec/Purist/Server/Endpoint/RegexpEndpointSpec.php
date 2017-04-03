<?php

namespace spec\Purist\Server\Endpoint;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\RegexpEndpoint;
use Purist\Server\Resource;

class RegexpEndpointSpec extends ObjectBehavior
{
    function let(Resource $resource)
    {
        $this->beConstructedWith('#^/hello-world$#', $resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(RegexpEndpoint::class);
        $this->shouldImplement(Endpoint::class);
    }

    function it_matches_regexp_strings(RequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);
        $this->match($request)->shouldReturn(true);
    }

    function it_returns_a_resource_from_request(RequestInterface $request, UriInterface $uri, $resource)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);
        $this->resource($request)->shouldReturn($resource);
    }

    function it_will_throw_exception_on_faulty_regexp(RequestInterface $request, UriInterface $uri, $resource)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);

        $this->beConstructedWith('not-a-regexp', $resource);
        $this->shouldThrow(InvalidArgumentException::class)->duringMatch($request);
    }
}