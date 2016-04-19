<?php

namespace Purist;

use Purist\Endpoint\Endpoint;

interface Application
{
    /**
     * @return Endpoint
     */
    public function run();
}
