<?php
declare(strict_types=1);

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;

final class MatchingEndpoint
{
    private $endpoints;

    public function __construct(Endpoint ...$endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     * @throws Exception
     */
    public function response(RequestInterface $request): ResponseInterface
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($request)) {
                return $endpoint->response($request);
            }
        }

        throw new Exception('No matching endpoint could be found.');
    }

    public function match(RequestInterface $request): bool
    {
        foreach ($this->endpoints as $endpoint) {
            if ($endpoint->match($request)) {
                return true;
            }
        }

        return false;
    }
}
