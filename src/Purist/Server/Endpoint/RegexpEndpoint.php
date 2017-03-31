<?php

namespace Purist\Server\Endpoint;

use Exception;
use InvalidArgumentException;
use Psr\Http\Message\RequestInterface;
use Purist\NoResource;
use Purist\Server\Endpoint\OptionalResponse;
use Purist\Server\Resource;

final class RegexpEndpoint implements Endpoint
{
    private $regexp;
    private $resource;

    public function __construct(string $regexp, Resource $resource)
    {
        $this->regexp = $regexp;
        $this->resource = $resource;
    }

    /**
     * @throws Exception
     */
    public function match(RequestInterface $request): bool
    {
        $matchResult = @preg_match($this->regexp, $request->getUri()->getPath());

        if ($matchResult === false) {
            throw new InvalidArgumentException(
                sprintf(
                    'Faulty regexp in endpoint: %s with uri: %s',
                    $this->regexp,
                    $request->getUri()->getPath()
                )
            );
        }

        return $matchResult === 1;
    }

    /**
     * @throws Exception
     */
    public function resource(RequestInterface $request): Resource
    {
        return $this->resource;
    }
}
