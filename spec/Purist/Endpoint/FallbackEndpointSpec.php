<?php

namespace spec\Purist\Endpoint;

use GuzzleHttp\Psr7\Response;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\HttpCall;

class FallbackEndpointSpec extends ObjectBehavior
{
    function let(HttpCall $httpCall)
    {
        $this->beConstructedWith($httpCall);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Endpoint\FallbackEndpoint');
        $this->shouldImplement('Purist\Endpoint\Endpoint');
    }

    function it_will_always_match_request(RequestInterface $request)
    {
        $this->match($request)->shouldReturn(true);
    }

    function it_will_return_response_of_http_call($httpCall, RequestInterface $request, ResponseInterface $response)
    {
        $httpCall->response($request)->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }
}
