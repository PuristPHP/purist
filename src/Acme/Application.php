<?php

namespace Acme;

use Psr\Http\Message\ServerRequestInterface;
use Purist\Server\Router\EndpointRouter;
use Purist\Server\Endpoint\FallbackEndpoint;
use Purist\Server\Endpoint\PathEndpoint;
use Purist\Server\Endpoint\RegexpEndpoint;

class Application
{
    private $dbConnection;
    private $twigExtensions;

    public function __construct()
    {
        $this->twigExtensions = new TwigExtensions(
            new TwigExtension,
            new AnotherTwigExtension(
                new TwigDependency
            )
        );
    }

    public function handle()
    {
        return new EndpointRouter(
            new PathEndpoint('/', new IndexPage),
            new RegexpEndpoint('^/hello/(?<name>[^/]+)$', new HelloWorldPage),
            new PathEndpoint(
                '/hello-another-world',
                new AnotherHelloWorldPage(
                    new PsrLogger('file/path'),
                    new TwigTemplate('views/hello-world', $this->twigExtensions)
                )
            ),
            new PathEndpoint(
                '/admin',
                new EndpointRouter(
                    new MiddlewaresFork(new AuthenticationMiddleware),
                    new AdminPages($this->dbConnection, $this->twigExtensions)
                )
            ),
            new FallbackEndpoint(new NotFoundPage)
        );
    }
}
