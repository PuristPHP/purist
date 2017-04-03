<?php

namespace Acme;

use GuzzleHttp\Psr7\Stream;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Exception;
use Purist\Header\HttpHeaders;
use Purist\Message;
use Purist\Response\Response;
use Purist\Server\Resource;

class HelloPage implements Resource
{
    public function response(RequestInterface $request): ResponseInterface
    {
        $stream = new Stream(fopen('php://temp', 'r+'));

        $stream->write('Det gick!');
        $stream->rewind();
        return new Response(new Message($stream, new HttpHeaders(['Content-Type' => 'text/html'])));
    }
}
