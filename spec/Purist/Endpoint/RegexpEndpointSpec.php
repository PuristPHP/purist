<?php

namespace spec\Purist\Endpoint;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\HttpCall;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;

class RegexpEndpointSpec extends ObjectBehavior
{
    function let(HttpCall $httpCall)
    {
        $this->beConstructedWith('#^/hello-world$#', $httpCall);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Endpoint\RegexpEndpoint');
        $this->shouldImplement('Purist\Endpoint\Endpoint');
    }

    function it_matches_regexp_strings(RequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);
        $this->match($request)->shouldReturn(true);
    }

    function it_returns_the_response_of_the_http_call($httpCall, RequestInterface $request, ResponseInterface $response)
    {
        $httpCall->response($request)->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }

    function it_will_throw_exception_on_faulty_regexp($httpCall, RequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);

        $this->beConstructedWith('not-a-regexp', $httpCall);
        $this->shouldThrow('Exception')->duringMatch($request);
    }
}
