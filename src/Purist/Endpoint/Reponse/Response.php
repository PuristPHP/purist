<?php

namespace Purist\Endpoint\Response;

use Exception;
use Psr\Http\Message\ResponseInterface;

final class Response implements Optional
{
    /**
     * @type ResponseInterface
     */
    private $response;

    public function __construct(ResponseInterface $response)
    {
        $this->response = $response;
    }

    /**
     * @return boolean
     */
    public function has()
    {
        return true;
    }

    /**
     * @return ResponseInterface
     * @throws Exception
     */
    public function get()
    {
        return $this->response;
    }
}
