<?php

namespace spec\Purist\Server;

use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Application;
use Purist\Http\Response\TextResponse;
use Purist\Server\ResourceServer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Server;

class ResourceServerSpec extends ObjectBehavior
{
    function let(RequestHandlerInterface $resource)
    {
        $this->beConstructedWith($resource);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ResourceServer::class);
        $this->shouldImplement(Server::class);
    }

    /**
     * Can not test that headers are being set on CLI
     */
    function it_sets_headers_and_returns_body(ServerRequestInterface $request, RequestHandlerInterface $resource)
    {
        $resource->handle($request)->willReturn(new TextResponse('hello world'));

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
