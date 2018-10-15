<?php

declare(strict_types=1);

use Acme\HelloNamePage;
use Acme\HelloWorldPage;
use Acme\NotAuthorizedPage;
use Acme\NotFoundPage;
use Acme\StatusCodePage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Request\GlobalServerRequest;
use Purist\Http\Response\TextResponse;
use Purist\Server\Router\ResponseEndpoint\StatusCodeEndpoint;
use Purist\Server\Router\ResponseRouterMiddleware;
use Purist\Server\MiddlewareServer;
use Purist\Server\DefaultServer;
use Purist\Server\Router\Endpoint\EndpointFork;
use Purist\Server\Router\Endpoint\MethodEndpoint;
use Purist\Server\Router\Endpoint\RegexpEndpoint;
use Purist\Server\Router\Resource\ResponseResource;
use Purist\Server\Router\Endpoint\PathEndpoint;
use Purist\Server\Router\RouterMiddleware;

require __DIR__ . '/../vendor/autoload.php';

$server = new MiddlewareServer(
//    new AuthenticationMiddleware(),
//    new CsrfMiddleware(),
    new ResponseRouterMiddleware(
        new StatusCodeEndpoint(404, new NotFoundPage()),
        new StatusCodeEndpoint(403, new NotAuthorizedPage())
    ),
    new RouterMiddleware(
        new PathEndpoint('/', new HelloWorldPage()),
        new RegexpEndpoint('(^/hello/(?<name>[^/]+)$)', new HelloNamePage()),
        new PathEndpoint(
            '/fork-methods',
            new EndpointFork(
                new MethodEndpoint(
                    'GET',
                    new ResponseResource(new TextResponse('method: GET'))
                ),
                new MethodEndpoint(
                    'POST',
                    new ResponseResource(new TextResponse('method: POST'))
                )
            )
        ),
        new RegexpEndpoint('(^/status-code/(?<statusCode>[^/]+)$)', new StatusCodePage)
    )
);

try {
    $server->serve($request = GlobalServerRequest::create());
} catch (Exception $exception) {
    (new DefaultServer(
        new class($exception) implements RequestHandlerInterface
        {
            private $exception;

            public function __construct(Exception $exception)
            {
                $this->exception = $exception;
            }

            public function handle(ServerRequestInterface $request): ResponseInterface
            {
                return new TextResponse($this->exception->getMessage(), 500);
            }
        }
    ))->serve($request);
}
