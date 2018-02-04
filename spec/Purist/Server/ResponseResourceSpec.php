<?php

namespace spec\Purist\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\ResponseResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ResponseResourceSpec extends ObjectBehavior
{
    function let(ResponseInterface $response)
    {
        $this->beConstructedWith($response);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResponseResource::class);
        $this->shouldHaveType(RequestHandlerInterface::class);
    }

    function it_always_returns_the_response(ServerRequestInterface $request, $response)
    {
        $this->handle($request)->shouldReturn($response);
    }
}
