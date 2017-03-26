<?php
namespace Purist\Endpoint;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface Endpoint
{
    /**
     * @throws Exception
     */
    public function response(RequestInterface $request): ResponseInterface;
}
