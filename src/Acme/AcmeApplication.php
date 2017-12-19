<?php
declare(strict_types=1);

namespace Acme;

use Purist\Application;
use Purist\Http\Response\TextResponse;
use Purist\Server\Endpoint\EndpointFork;
use Purist\Server\Endpoint\MethodEndpoint;
use Purist\Server\Endpoint\RegexpEndpoint;
use Purist\Server\Middleware\MiddlewaresResource;
use Purist\Server\Resource;
use Purist\Server\ResponseResource;
use Purist\Server\Endpoint\PathEndpoint;

class AcmeApplication implements Application
{
    public function run(): Resource
    {
        return new MiddlewaresResource(
            new EndpointForkMiddleware(
                new PathEndpoint('/', new HelloWorldPage()),
                new RegexpEndpoint('(^/hello/(?<name>[^/]+)$)', new HelloNamePage()),
                new PathEndpoint(
                    '/fork-methods',
                    new EndpointFork(
                        new MethodEndpoint('GET',
                            new ResponseResource(new TextResponse('method: GET'))
                        ),
                        new MethodEndpoint(
                            'POST',
                            new ResponseResource(new TextResponse('method: POST'))
                        )
                    )
                )
            ),
            new ResponseStatusCodeMiddleware(
                new StatusCodeEndpoint(404, new NotFoundPage()),
                new StatusCodeEndpoint(403, new NotAuthorizedPage())
            )
        );
    }
}
