<?php
use Purist\Endpoint\FallbackEndpoint;
use Purist\Endpoint\MatchingEndpoint;
use Purist\Endpoint\PathEndpoint;
use Purist\Endpoint\RegexpEndpoint;

class Application
{
    private $dbConnection;
    private $request;

    public function __construct()
    {

    }

    public function run()
    {
        (new HttpClient(
            new Middlewares(
                $this->request,
                new CookieMiddleware,
                new SessionMiddleware
            ),
            new MatchingEndpoint(
                new RegexpEndpoint('^/hello/(?<name>[^/]+)$', new HelloWorldPage),
                new PathEndpoint('/hello-another-world', new AnotherHelloWorldPage),
                new PathEndpoint(
                    '/users',
                    new UserEndpoints(
                        new Users($this->dbConnection)
                    )
                ),
                new FallbackEndpoint(new NotFoundPage)
            )
        ))->sendResponse();
    }
}

try {
    (new Application)->run();
} catch (Exception $exception) {
    (new Logger)->log($exception);
}
