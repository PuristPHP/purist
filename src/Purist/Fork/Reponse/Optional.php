<?php

namespace Purist\Fork\Response;

use Exception;
use Psr\Http\Message\RequestInterface;

interface Optional
{
    /**
     * @return boolean
     */
    public function has();

    /**
     * @return RequestInterface
     * @throws Exception
     */
    public function get();
}
