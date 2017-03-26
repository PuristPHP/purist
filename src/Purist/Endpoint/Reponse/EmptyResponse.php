<?php

namespace Purist\Endpoint\Response;

use Exception;
use Psr\Http\Message\RequestInterface;

final class EmptyResponse implements Optional
{
    /**
     * @return boolean
     */
    public function has()
    {
        return false;
    }

    /**
     * @return RequestInterface
     * @throws Exception
     */
    public function get()
    {
        throw new Exception('You can not get an empty Response');
    }
}
