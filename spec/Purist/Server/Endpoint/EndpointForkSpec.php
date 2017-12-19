<?php

namespace spec\Purist\Server\Endpoint;

use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\Endpoint\Endpoint;
use Purist\Server\Endpoint\EndpointFork;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class EndpointForkSpec extends ObjectBehavior
{
    function let(Endpoint $endpoint1, Endpoint $endpoint2)
    {
        $this->beConstructedWith($endpoint1, $endpoint2);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(EndpointFork::class);
        $this->shouldImplement(Endpoint::class);
    }

    function it_forks_requests(ServerRequestInterface $request, Endpoint $endpoint1, Endpoint $endpoint2)
    {
        $request->getMethod()->willReturn('POST');
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(true);
        $endpoint2->response($request)->willReturn($response = new TextResponse('test'));

        $this->response($request)->shouldReturn($response);
    }
}
