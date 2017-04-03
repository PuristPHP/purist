<?php

use Acme\AcmeApplication;
use Acme\FileLogger;
use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Message;
use Purist\ResourceApplication;
use Purist\Response\Response;
use Purist\Server\ApplicationServer;
use Purist\Server\Resource;

require __DIR__ . '/../vendor/autoload.php';

try {
    (new ApplicationServer(new AcmeApplication))->serve();
} catch (Exception $exception) {
    (new ApplicationServer(
        new ResourceApplication(
            new class implements Resource {
                public function response(RequestInterface $request): ResponseInterface {
                    $stream = new Stream(fopen('php://temp', 'r+'));
                    $stream->write('test');
                    $stream->rewind();

                    return new Response(new Message($stream), 404);
                }
            }
        )
    ))->serve();
}
