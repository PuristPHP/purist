<?php

namespace spec\Purist\Message;

use InvalidArgumentException;
use PhpSpec\ObjectBehavior;
use stdClass;

class ValidHeaderSpec extends ObjectBehavior
{
    function it_will_throw_exception_on_empty_name()
    {
        $this->beConstructedWith('', 'value');
        $this->shouldThrow(InvalidArgumentException::class)->during('name');
    }

    function it_will_throw_exception_on_non_string_name()
    {
        $this->beConstructedWith(true, 'value');
        $this->shouldThrow(InvalidArgumentException::class)->during('name');
    }

    function it_get_a_valid_name()
    {
        $this->beConstructedWith('Content-Type', 'value');
        $this->name()->shouldReturn('Content-Type');
    }

    function it_will_throw_exception_when_value_is_not_string_or_array()
    {
        $this->beConstructedWith('name', new stdClass());
        $this->shouldThrow(InvalidArgumentException::class)->during('value');
    }

    function it_get_a_valid_string_value()
    {
        $this->beConstructedWith('name', 'text/html');
        $this->value()->shouldReturn('text/html');
    }

    function it_get_a_valid_array_value()
    {
        $this->beConstructedWith('name', ['text/html', 'application/javascript']);
        $this->value()->shouldReturn(['text/html', 'application/javascript']);
    }
}
