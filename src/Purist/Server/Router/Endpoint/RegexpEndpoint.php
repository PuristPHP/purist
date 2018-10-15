<?php

declare(strict_types=1);

namespace Purist\Server\Router\Endpoint;

use InvalidArgumentException;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Purist\Server\Router\Endpoint;

final class RegexpEndpoint implements Endpoint
{
    private $regexp;
    private $resource;

    public function __construct(string $regexp, RequestHandlerInterface $resource)
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        preg_match($this->regexp, $request->getUri()->getPath(), $matches);

        return $this->resource->handle(
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
