<?php

namespace spec\Purist\Server;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;
use Purist\Server\MiddlewareServer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MiddlewareServerSpec extends ObjectBehavior
{
    function let(MiddlewareInterface $middleware)
    {
        $this->beConstructedWith($middleware);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(MiddlewareServer::class);
    }

    function it_sets_headers_and_outputs_body(ServerRequestInterface $request, MiddlewareInterface $middleware)
    {
        $middleware
            ->process($request, Argument::type(RequestHandlerInterface::class))
            ->willReturn(new TextResponse('hello world'));

        ob_start();
        $sut = $this->serve($request);
        $output = ob_get_clean();

        $sut->shouldOutput('hello world', $output);
    }

    public function getMatchers(): array
    {
        return [
            'output' => function ($subject, $expectedOutput, $output) {
                return $expectedOutput === $output;
            },
        ];
    }
}
