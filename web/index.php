<?php

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Request\GlobalServerRequest;
use Purist\Http\Response\TextResponse;
use Purist\Server\MiddlewareServer;
use Purist\Server\ResourceServer;
use Purist\Server\Resource;
use Purist\Server\Endpoint\EndpointFork;
use Purist\Server\Endpoint\MethodEndpoint;
use Purist\Server\Endpoint\RegexpEndpoint;
use Purist\Server\ResponseResource;
use Purist\Server\Endpoint\PathEndpoint;

require __DIR__ . '/../vendor/autoload.php';

$server = new MiddlewareServer(
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
        )
    ),
    new ResponseForkMiddleware(
        new StatusCodeEndpoint(404, new NotFoundPage()),
        new StatusCodeEndpoint(403, new NotAuthorizedPage())
    )
);

try {
    $server->serve($request = GlobalServerRequest::create());
} catch (Exception $exception) {
    (new ResourceServer(
        new class implements Resource {
            public function response(ServerRequestInterface $request): ResponseInterface {
                return new TextResponse('Something went wrong with the request', 500);
            }
        }
    ))->serve($request);
}
