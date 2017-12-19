<?php

namespace spec\Purist\Server;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Message;
use Purist\Http\Response\Response;
use Purist\Application;
use Purist\Exception;
use Purist\Http\Response\TextResponse;
use Purist\Server\ApplicationServer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Endpoint\FallbackEndpoint;
use Purist\Server\Resource;
use Purist\Server\ResponseResource;
use Purist\Server\Router\Router;
use Purist\Server\Server;

class ApplicationServerSpec extends ObjectBehavior
{
    function let(Application $application, ServerRequestInterface $request)
    {
        $this->beConstructedWith($application, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApplicationServer::class);
        $this->shouldImplement(Server::class);
    }

    /**
     * Can not test that headers are being set on CLI
     */
    function it_sets_headers_and_returns_body(Application $application)
    {
        $application->run()->willReturn(new FallbackEndpoint(new ResponseResource(new TextResponse('hello world'))));

        ob_start();
        $this->serve()->shouldOutput('hello world');
    }

    public function getMatchers()
    {
        return [
            'output' => function ($subject, $output) {
                $response = ob_get_clean();
                return $response === $output;
            },
        ];
    }
}
