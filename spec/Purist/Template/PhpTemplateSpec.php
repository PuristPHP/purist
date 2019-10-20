<?php

namespace spec\Purist\Template;

use Purist\Template\PhpTemplate;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class PhpTemplateSpec extends ObjectBehavior
{
    function let()
    {
        $this->beConstructedWith(__DIR__ . '/templates');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(PhpTemplate::class);
    }

    function it_renders_templates_with_variables()
    {
        $this->render('sub-dir/page.php', ['name' => 'Nicholas'])
            ->callOnWrappedObject('getBody')
            ->callOnWrappedObject('getContents')
            ->shouldContain('Hello Nicholas');

        $this->render('/sub-dir/page.php', ['name' => 'Steve'])
            ->callOnWrappedObject('getBody')
            ->callOnWrappedObject('getContents')
            ->shouldContain('Hello Steve');
    }

    function it_throws_exception_when_template_not_found()
    {
        $this->shouldThrow()->duringRender('page.php');
        $this->shouldThrow()->duringRender('not-sub-dir/page.php');
    }
}
