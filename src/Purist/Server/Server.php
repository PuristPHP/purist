<?php

namespace Purist\Server;

interface Server
{
    /**
     * @throws Exception
     */
    public function serve(): void;
}
