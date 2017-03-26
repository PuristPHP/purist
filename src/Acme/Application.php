<?php

namespace Acme;

use Purist\Endpoint\MatchingEndpoint;
use Purist\Endpoint\FallbackEndpoint;
use Purist\Endpoint\Endpoint;
use Purist\Endpoint\MatchingEndpoint;
use Purist\Endpoint\PathEndpoint;
use Purist\Endpoint\RegexpEndpoint;

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

    public function run()
    {
        return new MatchingEndpoint(
            new MiddlewaresFork(
                new CookieMiddleware,
                new SessionMiddleware
            ),
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
                new MatchingEndpoint(
                    new MiddlewaresFork(new AuthenticationMiddleware),
                    new AdminPages($this->dbConnection, $this->twigExtensions)
                )
            ),
            new FallbackEndpoint(new NotFoundPage)
        );
    }
}
