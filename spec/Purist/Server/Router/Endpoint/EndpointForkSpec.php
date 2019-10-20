<?php

namespace spec\Purist\Server\Router\Endpoint;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\Router\Endpoint;
use Purist\Server\Router\Endpoint\EndpointFork;
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
        $this->shouldImplement(RequestHandlerInterface::class);
    }

    function it_forks_requests(
        ServerRequestInterface $request,
        Endpoint $endpoint1,
        Endpoint $endpoint2
    ) {
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(true);
        $endpoint2->handle($request)->willReturn(
            $response = new TextResponse('test')
        );

        $this->handle($request)->shouldReturn($response);
    }

    function it_returns_404_response_if_no_endpoint_matches(
        ServerRequestInterface $request,
        Endpoint $endpoint1,
        Endpoint $endpoint2
    ) {
        $endpoint1->match($request)->willReturn(false);
        $endpoint2->match($request)->willReturn(false);

        $this->handle($request)
            ->callOnWrappedObject('getStatusCode')
            ->shouldBe(404);
    }
}
