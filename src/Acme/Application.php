<?php

namespace Acme;

use Purist\Fork\FallbackFork;
use Purist\Fork\Endpoint;
use Purist\Fork\MatchingEndpoint;
use Purist\Fork\PathFork;
use Purist\Fork\RegexpFork;

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
            new PathFork('/', new IndexPage),
            new RegexpFork('^/hello/(?<name>[^/]+)$', new HelloWorldPage),
            new PathFork(
                '/hello-another-world',
                new AnotherHelloWorldPage(
                    new PsrLogger('file/path'),
                    new TwigTemplate('views/hello-world', $this->twigExtensions)
                )
            ),
            new PathFork(
                '/admin',
                new MatchingEndpoint(
                    new MiddlewaresFork(new AuthenticationMiddleware),
                    new AdminPages($this->dbConnection, $this->twigExtensions)
                )
            ),
            new FallbackFork(new NotFoundPage)
        );
    }
}
