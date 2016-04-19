<?php

namespace Purist\Application;

use Purist\Application;
use Purist\Endpoint\Endpoint;

final class EndpointApplication implements Application
{
    /**
     * @type Endpoint
     */
    private $endpoint;

    /**
     * @type RequestFromGlobals
     */
    private $request;

    /**
     * EndpointApplication constructor.
     * @param Endpoint $endpoint
     */
    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
        $this->request = new RequestFromGlobals;
    }

    /**
     * @return Endpoint
     */
    public function run()
    {
        return $this->endpoint;
    }
}
