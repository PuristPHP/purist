<?php

namespace Purist\Server;

use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Purist\Application;

final class ApplicationServer implements Server
{
    private $application;
    private $request;

    public function __construct(Application $application, RequestInterface $request = null)
    {
        $this->application = $application;
        $this->request = $request ?? new RequestFromGlobals;
    }

    /**
     * @throws Exception
     */
    public function serve(): void
    {
        /** @var ResponseInterface $response */
        $response = $this->application->run()->response($this->request);

         foreach ($response->getHeaders() as $name => $values) {
             foreach ($values as $value) {
                 header(sprintf('%s: %s', $name, $value), false);
             }
         }

        print $response->getBody()->getContents();
    }
}
