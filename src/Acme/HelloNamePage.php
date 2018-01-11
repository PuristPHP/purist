<?php

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Exception;
use Purist\Http\Response\TextResponse;
use Purist\Message;
use Purist\Server\Resource;

class xHelloNamePage implements Resource
{
    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            sprintf('Hello %s!', $request->getAttribute('name'))
        );
    }
}
