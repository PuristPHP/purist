<?php

declare(strict_types=1);

namespace Purist\Server;

interface Server
{
    /**
     * @throws Exception
     */
    public function serve(): void;
}
