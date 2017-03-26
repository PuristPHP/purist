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

    public function __construct(Endpoint $endpoint)
    {
        $this->endpoint = $endpoint;
    }

    /**
     * @return Endpoint
     */
    public function run(): Endpoint
    {
        return $this->endpoint;
    }
}
