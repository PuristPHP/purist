<?php

namespace Purist\Fork;

use Psr\Http\Message\RequestInterface;
use Purist\Fork\Response\Optional;

interface Fork
{
    /**
     * @param RequestInterface $request
     * @return Optional
     */
    public function route(RequestInterface $request);
}
