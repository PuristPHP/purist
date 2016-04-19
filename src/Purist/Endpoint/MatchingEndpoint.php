<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Exception;
use Psr\Http\Message\ResponseInterface;

final class MatchingEndpoint implements Endpoint
{
    private $forks;

    /**
     * MatchingEndpoint constructor.
     * @param Fork[] ...$forks
     */
    public function __construct(Fork ...$forks)
    {
        $this->forks = $forks;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     * @throws Exception
     */
    public function response(RequestInterface $request)
    {
        foreach ($this->forks as $fork) {
            if ($fork->route($request)->has()) {
                return $fork->route($request)->get();
            }
        }

        throw new Exception('No matching fork could be found.');
    }
}
