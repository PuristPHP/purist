<?php
declare(strict_types=1);

namespace Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Middlewares
{
    public function handle(ServerRequestInterface $request): ResponseInterface;
}
