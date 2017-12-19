<?php

namespace spec\Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Middleware\Middleware;
use Purist\Server\Middleware\Middlewares;
use Purist\Server\Middleware\MiddlewaresResource;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewaresResourceSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewaresResource::class);
    }

    function it_will_call_ordered_middlewares(ServerRequestInterface $request, Middleware $middleware, ResponseInterface $response)
    {
        $this->beConstructedWith($middleware);
        $middleware->handle($request, Argument::type(Middlewares::class))->willReturn($response);
        $this->response($request)->shouldReturn($response);
    }
}
