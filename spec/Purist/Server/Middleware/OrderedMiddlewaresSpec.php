<?php

namespace spec\Purist\Server\Middleware;

use Purist\Server\Middleware\OrderedMiddlewares;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class OrderedMiddlewaresSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(OrderedMiddlewares::class);
    }
}
