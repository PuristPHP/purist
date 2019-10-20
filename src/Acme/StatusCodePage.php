<?php

declare(strict_types=1);

namespace Acme;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Http\Response\TextResponse;

final class StatusCodePage implements RequestHandlerInterface
{
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        return new TextResponse(
            sprintf(
                'This page is served with status code: %d',
                $statusCode = (int) $request->getAttribute('statusCode')
            ),
            $statusCode
        );
    }
}
