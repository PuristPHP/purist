<?php
declare(strict_types=1);

namespace Purist\Server\Endpoint;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
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

    public function match(ServerRequestInterface $request): bool
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

    public function response(ServerRequestInterface $request): ResponseInterface
    {
        preg_match($this->regexp, $request->getUri()->getPath(), $matches);

        return $this->resource->response(
            array_reduce(
                array_keys($matches),
                function (ServerRequestInterface $request, $key) use ($matches) {
                    if (filter_var($key, FILTER_VALIDATE_INT) !== false) {
                        return $request;
                    }

                    return $request->withAttribute($key, $matches[$key]);
                },
                $request
            )
        );
    }
}
