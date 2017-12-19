<?php
declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

interface Resource
{
    public function response(ServerRequestInterface $request): ResponseInterface;
}
