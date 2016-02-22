<?php

namespace spec\Purist\Endpoints;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\UriInterface;
use Purist\HttpCall;

class PathEndpointSpec extends ObjectBehavior
{
    function let(HttpCall $httpCall)
    {
        $this->beConstructedWith('/hello-world', $httpCall);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Endpoints\PathEndpoint');
        $this->shouldImplement('Purist\Endpoints\Endpoint');
    }

    function it_matches_a_path_by_string(RequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-world');
        $request->getUri()->willReturn($uri);

        $this->match($request)->shouldReturn(true);
    }

    function it_will_not_match_a_different_path(RequestInterface $request, UriInterface $uri)
    {
        $uri->getPath()->willReturn('/hello-worldo');
        $request->getUri()->willReturn($uri);

        $this->match($request)->shouldReturn(false);
    }

    function it_will_return_response_of_http_call($httpCall, RequestInterface $request, ResponseInterface $response)
    {
        $httpCall->response($request)->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }
}
