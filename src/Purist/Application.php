<?php

declare(strict_types=1);

namespace Purist;

use Purist\Server\Router\Router;

interface Application
{
    public function run(): Router;
}
