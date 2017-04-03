<?php

declare(strict_types=1);

namespace Purist\Server\Endpoint;

use Exception;
use Psr\Http\Message\RequestInterface;
use Purist\Server\Resource;

interface Endpoint
{
    public function match(RequestInterface $request): bool;

    /**
     * @throws Exception
     */
    public function resource(): Resource;
}
