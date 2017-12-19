<?php

use Acme\AcmeApplication;
use Acme\FileLogger;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Http\Request\GlobalServerRequest;
use Purist\Http\Response\Response;
use Purist\Http\Response\TextResponse;
use Purist\Http\Stream\LazyReadOnlyTextStream;
use Purist\Message;
use Purist\ResourceApplication;
use Purist\Server\ApplicationServer;
use Purist\Server\Resource;

require __DIR__ . '/../vendor/autoload.php';

try {
    $request = GlobalServerRequest::create();
    (new ApplicationServer(new AcmeApplication, $request))->serve();
} catch (Exception $exception) {
    (new ApplicationServer(
        new ResourceApplication(
            new class implements Resource {
                public function response(RequestInterface $request): ResponseInterface {
                    return new TextResponse('Something went wrong with the request', 500);
                }
            }
        ),
        $request
    ))->serve();
}
