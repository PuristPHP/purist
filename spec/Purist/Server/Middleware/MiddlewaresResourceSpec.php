<?php

namespace spec\Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Middleware\MiddlewaresResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewaresResourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewaresResource::class);
    }

    function it_will_call_ordered_middlewares(ServerRequestInterface $request, MiddlewareInterface $middleware, ResponseInterface $response)
    {
        $this->beConstructedWith($middleware);
        $middleware->process($request, Argument::type(RequestHandlerInterface::class))->willReturn($response);
        $this->handle($request)->shouldReturn($response);
    }
}
