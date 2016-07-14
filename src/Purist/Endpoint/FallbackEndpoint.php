<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\HttpCall;

class FallbackEndpoint implements Endpoint
{
    /**
     * @var HttpCall
     */
    private $httpCall;

    public function __construct(HttpCall $httpCall)
    {
        $this->httpCall = $httpCall;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function response(RequestInterface $request)
    {
        return $this->httpCall->response($request);
    }

    /**
     * @param RequestInterface $request
     * @return bool
     */
    public function match(RequestInterface $request)
    {
        return true;
    }
}
