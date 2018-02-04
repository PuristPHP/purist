<?php

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Header\HttpHeaders;
use Purist\Http\Response\TextResponse;

class HelloWorldPage implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            'Hello World!',
            200,
            new HttpHeaders(['Content-Type' => 'text/html'])
        );
    }
}
