<?php

namespace Purist\Server;

interface Server
{
    /**
     * @return void
     * @throws Exception
     */
    public function serve();
}
