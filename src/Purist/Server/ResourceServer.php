<?php

declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Message\ServerRequestInterface;

class ResourceServer implements Server
{
    private $resource;

    public function __construct(Resource $resource)
    {
        $this->resource = $resource;
    }

    final public function serve(ServerRequestInterface $request): void
    {
        $response = $this->resource->response($request);

        header(
            sprintf(
                'HTTP/%s %s %s',
                $response->getProtocolVersion(),
                $response->getStatusCode(),
                $response->getReasonPhrase()
            ),
            true,
            $response->getStatusCode()
        );

        foreach ($response->getHeaders() as $name => $values) {
            foreach ($values as $value) {
                header(sprintf('%s: %s', $name, $value), false, $response->getStatusCode());
            }
        }

        print $response->getBody()->getContents();

        $this->finishRequest();
    }

    private function finishRequest(): void
    {
        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif ('cli' !== PHP_SAPI) {
            $this->cleanOutputBuffers();
        }
    }

    private function cleanOutputBuffers(): void
    {
        $status = ob_get_status(true);
        $level = count($status);
        // PHP_OUTPUT_HANDLER_* are not defined on HHVM 3.3
        $flags = defined('PHP_OUTPUT_HANDLER_REMOVABLE') ? PHP_OUTPUT_HANDLER_REMOVABLE | PHP_OUTPUT_HANDLER_FLUSHABLE : -1;
        while ($level-- > 0 && ($s = $status[$level]) && (!isset($s['del']) ? !isset($s['flags']) || $flags === ($s['flags'] & $flags) : $s['del'])) {
            ob_end_flush();
        }
    }
}
