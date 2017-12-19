<?php
declare(strict_types=1);

namespace Purist\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Middleware
{
    public function handle(ServerRequestInterface $request, Middlewares $rest): ResponseInterface;
}
