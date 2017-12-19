<?php

declare(strict_types=1);

namespace Purist\Server;

interface Server
{
    public function serve(): void;
}
