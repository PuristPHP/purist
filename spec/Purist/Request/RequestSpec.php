<?php

namespace spec\Purist\Request;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class RequestSpec extends ObjectBehavior
{
    const STANDARD_PROTOCOL_VERSION = '1.1';

    function let()
    {
        $this->beConstructedWith(self::STANDARD_PROTOCOL_VERSION);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Request\Request');
        $this->shouldImplement('Psr\Http\Message\RequestInterface');
    }

    function it_gets_headers()
    {
        $this->getHeaders()->shouldReturn(['Content-type' => ['text-html']]);
    }
}
