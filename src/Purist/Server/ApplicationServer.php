<?php

declare(strict_types=1);

namespace Purist\Server;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Purist\Application;
use Purist\Request\Request;
use Purist\Request\ServerRequest;

final class ApplicationServer implements Server
{
    private $application;
    private $request;

    public function __construct(Application $application, ServerRequestInterface $request)
    {
        $this->application = $application;
        $this->request = $request;
    }

    /**
     * @throws Exception
     */
    public function serve(): void
    {
        /** @var ResponseInterface $response */
        $response = $this->application->run()->route($this->request)->response($this->request);

         foreach ($response->getHeaders() as $name => $values) {
             foreach ($values as $value) {
                 header(sprintf('%s: %s', $name, $value), false, $response->getStatusCode());
             }
         }

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

        print $response->getBody()->getContents();

        if (function_exists('fastcgi_finish_request')) {
            fastcgi_finish_request();
        } elseif ('cli' !== PHP_SAPI) {
            $this->cleanOutputBuffers();
        }
    }

    private function cleanOutputBuffers()
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
