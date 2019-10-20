<?php

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;

class HelloNamePage implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            sprintf('Hello %s!', $request->getAttribute('name'))
        );
    }
}
