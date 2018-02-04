<?php

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Http\Response\TextResponse;
use Purist\Message;

class HelloNamePage implements Resource
{
    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            sprintf('Hello %s!', $request->getAttribute('name'))
        );
    }
}
