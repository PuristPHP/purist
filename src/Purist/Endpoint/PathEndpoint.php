<?php

namespace Purist\Endpoint;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\HttpCall;

final class PathEndpoint implements Endpoint
{
    private $path;
    private $httpCall;

    /**
     * PathEndpoint constructor.
     * @param $path
     * @param HttpCall $httpCall
     */
    public function __construct($path, HttpCall $httpCall)
    {
        $this->path = $path;
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
        return $this->path === $request->getUri()->getPath();
    }
}
