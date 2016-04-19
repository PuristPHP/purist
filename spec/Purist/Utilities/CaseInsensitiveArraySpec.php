<?php

namespace spec\Purist\Utilities;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class CaseInsensitiveArraySpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(
            [
                'SomeKey' => 'SomeValue',
                'AnotherKey' => 'AnotherValue',
            ]
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Utilities\CaseInsensitiveArray');
        $this->shouldImplement('ArrayAccess');
    }

    function it_checks_if_key_exists_case_insensitively()
    {
        $this->offsetExists('somekey')->shouldReturn(true);
        $this->offsetExists('AnOtHeRkEY')->shouldReturn(true);
    }

    function it_gets_value_from_key_case_insensitively()
    {
        $this->offsetGet('sOmeKeY')->shouldReturn('SomeValue');
        $this->offsetGet('aNotherKeY')->shouldReturn('AnotherValue');
    }
}
