<?php

namespace spec\Purist\Request;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class RequestUriSpec extends ObjectBehavior
{
    function let(RequestInterface $request)
    {
        $this->beConstructedWith($request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Request\RequestUri');
    }

    function it_represents_the_request_uri_string($request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);
        $this->toString()->shouldReturn('/hello-world');

        $uri->getPath()->willReturn('/hello-small-world');
        $request->getUri()->willReturn($uri);
        $this->toString()->shouldReturn('/hello-small-world');
    }

    function it_matches_against_uri_string($request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-third-world');
        $request->getUri()->willReturn($uri);

        $this->match('/hello-third-world')->shouldReturn(true);
        $this->match('/hello-world')->shouldReturn(false);
    }
}
