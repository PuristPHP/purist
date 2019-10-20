<?php

declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Message\ServerRequestInterface;

interface Server
{
    public function serve(ServerRequestInterface $request): void;
}
