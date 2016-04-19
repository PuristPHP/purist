<?php

namespace Purist\Fork;

use Exception;
use Psr\Http\Message\RequestInterface;
use Purist\Endpoint\Endpoint;
use Purist\Fork\Response\EmptyResponse;
use Purist\Fork\Response\Optional;
use Purist\Fork\Response\Response;
use Purist\Request\RequestUri;

final class RegexpFork implements Fork
{
    private $regexp;
    private $endpoint;

    /**
     * RegexpEndpoint constructor.
     * @param string $regexp
     * @param Endpoint $endpoint
     */
    public function __construct($regexp, Endpoint $endpoint)
    {
        $this->regexp = $regexp;
        $this->endpoint = $endpoint;
    }

    /**
     * @param RequestInterface $request
     * @return Optional
     */
    public function route(RequestInterface $request)
    {
        if (!$this->match($request)) {
            return new EmptyResponse();
        }

        return new Response(
            $this->endpoint->response($request)
        );
    }

    /**
     * @param RequestInterface $request
     * @return bool
     * @throws Exception
     */
    private function match(RequestInterface $request)
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
}
