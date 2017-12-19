<?php
declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

final class ResponseResource implements Resource
{
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        return $this->response;
    }
}
