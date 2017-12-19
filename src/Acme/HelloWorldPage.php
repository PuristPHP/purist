<?php

namespace Acme;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Exception;
use Purist\Http\Header\HttpHeaders;
use Purist\Http\Response\TextResponse;
use Purist\Message;
use Purist\Server\Resource;

class HelloWorldPage implements Resource
{
    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            'Hello World!',
            200,
            new HttpHeaders(['Content-Type' => 'text/html'])
        );
    }
}
