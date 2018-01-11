<?php

namespace spec\Purist\Server;

use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\Middleware\Middleware;
use Purist\Server\Middleware\Middlewares;
use Purist\Server\Middleware\MiddlewaresResource;
use Purist\Server\Middleware\OrderedMiddlewares;
use Purist\Server\MiddlewareServer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewareServerSpec extends ObjectBehavior
{
    function let(Middleware $middleware)
    {
        $this->beConstructedWith($middleware);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewareServer::class);
    }

    function it_sets_headers_and_returns_body(ServerRequestInterface $request, Middleware $middleware)
    {
        $middleware
            ->handle($request, Argument::type(Middlewares::class))
            ->willReturn(new TextResponse('hello world'));

        ob_start();
        $sut = $this->serve($request);
        $output = ob_get_clean();

        $sut->shouldOutput('hello world', $output);
    }

    public function getMatchers()
    {
        return [
            'output' => function ($subject, $expectedOutput, $output) {
                return $expectedOutput === $output;
            },
        ];
    }
}
