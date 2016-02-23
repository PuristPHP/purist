<?php

namespace spec\Purist\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class HttpHeadersSpec extends ObjectBehavior
{
    private $headers = [
        'Content-Type' => 'text/html',
        'Accept' => ['text/html', 'application/javascript'],
    ];

    function let()
    {
        $this->beConstructedWith($this->headers);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Message\HttpHeaders');
        $this->shouldImplement('Purist\Message\Headers');
    }

    function it_checks_if_header_exists_case_insensitively()
    {
        $this->has('Content-Type')->shouldReturn(true);
        $this->has('content-type')->shouldReturn(true);
        $this->has('Accept')->shouldReturn(true);
        $this->has('accept')->shouldReturn(true);
        $this->has('Cache-Control')->shouldReturn(false);
        $this->has('cache-control')->shouldReturn(false);
    }

    function it_gets_values_from_a_header_as_array()
    {
        $this->header('content-type')->shouldReturn(['text/html']);
        $this->header('Cache-Control')->shouldReturn([]);
    }

    function it_gets_all_headers_with_keys_and_values()
    {
        $this->toArray()->shouldReturn([
            'Content-Type' => ['text/html'], // text/html changed to array
            'Accept' => ['text/html', 'application/javascript']
        ]);
    }

    function it_gets_values_from_a_header_as_comma_separated_string()
    {
        $this->headerLine('Accept')->shouldReturn('text/html,application/javascript');
        $this->headerLine('Cache-Control')->shouldReturn('');
    }

    function it_gets_a_new_instance_with_changed_headers()
    {
        $this
            ->replace('Cache-Control', 'max-age=3200')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
                'Cache-Control' => ['max-age=3200'], // max-age changed to array
            ]);

        $this
            ->replace('accept', 'text/css')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'accept' => ['text/css'],
            ]);

        $this->shouldThrow('InvalidArgumentException')
            ->duringReplace('', 'max-age=3200');

        $this->shouldThrow('InvalidArgumentException')
            ->duringReplace('Cache-Control', new \stdClass());
    }

    function it_returns_instance_with_appended_values_to_header()
    {
        $this
            ->add('accept', 'text/css')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript', 'text/css'],
            ]);

        $this
            ->add('cache-control', 'max-age=3600')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
                'cache-control' => ['max-age=3600'],
            ]);

        $this->shouldThrow('InvalidArgumentException')
            ->duringAdd('', 'max-age=3200');

        $this->shouldThrow('InvalidArgumentException')
            ->duringAdd('Cache-Control', new \stdClass());
    }

    function it_returns_instance_without_header() {
        $this
            ->remove('accept')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
            ]);

        // If header didn't exist return original headers
        $this
            ->remove('Authorization')
            ->callOnWrappedObject('toArray')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
            ]);
    }
}
