<?php

namespace Purist\Endpoint;

use Exception;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Endpoint\Response\EmptyResponse;
use Purist\Endpoint\Response\Response;
use Purist\Request\RequestUri;

final class RegexpEndpoint implements Endpoint
{
    private $regexp;
    private $endpoint;

    public function __construct(string $regexp, Endpoint $endpoint)
    {
        $this->regexp = $regexp;
        $this->endpoint = $endpoint;
    }

    public function response(RequestInterface $request): ResponseInterface
    {
        if (!$this->match($request)) {
            return new EmptyResponse();
        }

        return new Response(
            $this->endpoint->response($request)
        );
    }

    /**
     * @throws Exception
     */
    private function match(RequestInterface $request): bool
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
