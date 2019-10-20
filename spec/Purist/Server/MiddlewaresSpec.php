<?php

namespace spec\Purist\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Middlewares;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewaresSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Middlewares::class);
    }

    function it_will_call_ordered_middlewares(ServerRequestInterface $request, MiddlewareInterface $middleware, ResponseInterface $response)
    {
        $this->beConstructedWith($middleware);
        $middleware
            ->process($request, Argument::type(RequestHandlerInterface::class))
            ->willReturn($response);
        $this->handle($request)->shouldReturn($response);
    }

    function it_will_throw_exception_if_calling_non_existent_handler(ServerRequestInterface $request)
    {
        $this->beConstructedWith(
            new class implements MiddlewareInterface {
                public function process(
                    ServerRequestInterface $request,
                    RequestHandlerInterface $handler
                ): ResponseInterface{
                    return $handler->handle($request);
                }
            }
        );
        $this->shouldThrow(\Exception::class)->duringHandle($request);
    }
}
