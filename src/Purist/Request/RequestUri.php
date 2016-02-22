<?php

namespace Purist\Request;

use Psr\Http\Message\RequestInterface;

class RequestUri
{

    /**
     * @type RequestInterface
     */
    private $request;

    public function __construct(RequestInterface $request)
    {
        $this->request = $request;
    }

    public function toString()
    {
        return $this->request->getUri()->getPath();
    }

    public function match($uri)
    {
        return $this->toString() === $uri;
    }
}
