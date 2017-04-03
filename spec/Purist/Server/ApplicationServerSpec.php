<?php

namespace spec\Purist\Server;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Application;
use Purist\Exception;
use Purist\Message;
use Purist\Response\Response;
use Purist\Server\ApplicationServer;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Purist\Server\Resource;
use Purist\Server\Router\Router;

class ApplicationServerSpec extends ObjectBehavior
{
    function let(Application $application, ServerRequestInterface $request)
    {
        $this->beConstructedWith($application, $request);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ApplicationServer::class);
    }

    /**
     * Can not test that headers are being set on CLI
     */
    function it_sets_headers_and_returns_body(Application $application, ServerRequestInterface $request, Resource $resource, Router $router)
    {
        $application->run()->willReturn($router);
        $router->route($request)->willReturn(
            new class implements Resource {
                public function response(RequestInterface $request): ResponseInterface {
                    $body = fopen('php://temp', 'r+');
                    fwrite($body, 'hello world');
                    rewind($body);

                    return new Response(
                        new Message(
                            new Stream($body)
                        )
                    );
                }
            }
        );

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
