<?php

namespace Purist\Server;

use Psr\Http\Message\RequestInterface;
use Purist\Application;

final class PuristServer implements Server
{
    /**
     * @type Endpoint
     */
    private $application;

    /**
     * @type RequestInterface
     */
    private $request;

    public function __construct(Application $application) {
        $this->application = $application;
        $this->request = new RequestFromGlobals;
    }

    /**
     * @return void
     * @throws Exception
     */
    public function serve()
    {
        (new ClientResponse(
            $this->application->run()->response($this->request)
        ))->send();
    }
}
