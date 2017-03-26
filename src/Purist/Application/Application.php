<?php

namespace Purist;

use Purist\Endpoint\Endpoint;

interface Application
{
    public function run(): Endpoint;
}
