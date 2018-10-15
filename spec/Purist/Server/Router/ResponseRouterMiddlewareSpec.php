<?php

namespace spec\Purist\Server\Router;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Request\Request;
use Purist\Http\Request\ServerRequest;
use Purist\Http\Request\Uri;
use Purist\Http\Response\Response;
use Purist\Http\Response\TextResponse;
use Purist\Server\Middlewares;
use Purist\Server\Router\ResponseRouterMiddleware;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Router\ResponseEndpoint;

class ResponseRouterMiddlewareSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(ResponseRouterMiddleware::class);
        $this->shouldImplement(MiddlewareInterface::class);
    }

    function it_routes_matched_responses(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
        ResponseEndpoint $routedResponse,
        ResponseInterface $response
    ) {
        $this->beConstructedWith($routedResponse);

        $handler->handle($request)->willReturn($response);

        $routedResponse->match($response)->willReturn(true);
        $routedResponse->handle($request)->willReturn(
            $routedResponse = new TextResponse('hello')
        );

        $this->process($request, $handler)->shouldReturn($routedResponse);
    }

    function it_passes_response_when_nothing_matched(
        ServerRequestInterface $request,
        RequestHandlerInterface $handler,
        ResponseEndpoint $routedResponse,
        ResponseInterface $response
    ) {
        $this->beConstructedWith($routedResponse);

        $handler->handle($request)->willReturn($response);

        $routedResponse->match($response)->willReturn(false);
        $routedResponse->handle($request)->shouldNotBeCalled();

        $this->process($request, $handler)->shouldReturn($response);
    }
}
