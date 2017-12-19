<?php
declare(strict_types=1);

namespace Purist;

use Purist\Server\Resource;

interface Application
{
    public function run(): Resource;
}
