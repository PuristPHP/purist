<?php

namespace Purist\Endpoint;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\HttpCall;
use Purist\Request\RequestUri;

final class RegexpEndpoint implements Endpoint
{
    private $regexp;
    private $httpCall;

    /**
     * RegexpEndpoint constructor.
     * @param string $regexp
     * @param HttpCall $httpCall
     */
    public function __construct($regexp, HttpCall $httpCall)
    {
        $this->regexp = $regexp;
        $this->httpCall = $httpCall;
    }

    /**
     * @param RequestInterface $request
     * @return bool
     * @throws RuntimeException
     */
    public function match(RequestInterface $request)
    {
        $matchResult = preg_match($this->regexp, $request->getUri()->getPath());

        if ($matchResult === false) {
            throw new Exception(
                sprintf(
                    'Faulty regexp in endpoint: %s with uri: %s',
                    $this->regexp,
                    new RequestUri($request)
                )
            );
        }

        return $matchResult === 1;
    }

    /**
     * @param RequestInterface $request
     * @return ResponseInterface
     */
    public function response(RequestInterface $request)
    {
        return $this->httpCall->response($request);
    }
}
