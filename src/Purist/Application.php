<?php

namespace Purist;

use Purist\Server\Router\Router;

interface Application
{
    public function run(): Router;
}
