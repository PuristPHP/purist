<?php

namespace spec\Purist\Message;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Psr\Http\Message\StreamInterface;
use Purist\Message\HttpHeaders;

class HttpMessageSpec extends ObjectBehavior
{
    const STANDARD_PROTOCOL_VERSION = '1.1';

    private $headers = [
        'Content-Type' => 'text/html',
        'Accept' => ['text/html', 'application/javascript'],
    ];

    function let(StreamInterface $body)
    {
        $this->beConstructedWith(
            self::STANDARD_PROTOCOL_VERSION,
            new HttpHeaders($this->headers),
            $body
        );
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Message\HttpMessage');
        $this->shouldImplement('Psr\Http\Message\MessageInterface');
    }

    function it_gets_protocol_version()
    {
        $this->getProtocolVersion()->shouldReturn(self::STANDARD_PROTOCOL_VERSION);
    }

    function it_gets_a_new_instance_with_changed_protocol_version()
    {
        $this
            ->withProtocolVersion('1.0')
            ->callOnWrappedObject('getProtocolVersion')
            ->shouldReturn('1.0');
    }

    function it_checks_if_header_exists_case_insensitively($headers)
    {
        $this->hasHeader('Content-Type')->shouldReturn(true);
        $this->hasHeader('content-type')->shouldReturn(true);
        $this->hasHeader('Accept')->shouldReturn(true);
        $this->hasHeader('accept')->shouldReturn(true);
        $this->hasHeader('Cache-Control')->shouldReturn(false);
        $this->hasHeader('cache-control')->shouldReturn(false);
    }

    function it_gets_values_from_a_header_as_array()
    {
        $this->getHeader('content-type')->shouldReturn(['text/html']);
        $this->getHeader('Cache-Control')->shouldReturn([]);
    }

    function it_gets_all_headers_with_keys_and_values()
    {
        $this->getHeaders()->shouldReturn([
            'Content-Type' => ['text/html'], // text/html changed to array
            'Accept' => ['text/html', 'application/javascript']
        ]);
    }

    function it_gets_values_from_a_header_as_comma_separated_string()
    {
        $this->getHeaderLine('Accept')->shouldReturn('text/html,application/javascript');
        $this->getHeaderLine('Cache-Control')->shouldReturn('');
    }

    function it_gets_a_new_instance_with_replaced_headers()
    {
        $this
            ->withHeader('Cache-Control', 'max-age=3200')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
                'Cache-Control' => ['max-age=3200'], // max-age changed to array
            ]);

        $this
            ->withHeader('accept', 'text/css')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'accept' => ['text/css'],
            ]);

        $this->shouldThrow('InvalidArgumentException')
            ->duringWithHeader('', 'max-age=3200');

        $this->shouldThrow('InvalidArgumentException')
            ->duringWithHeader('Cache-Control', new \stdClass());
    }

    function it_returns_instance_with_appended_values_to_header()
    {
        $this
            ->withAddedHeader('accept', 'text/css')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript', 'text/css'],
            ]);

        $this
            ->withAddedHeader('cache-control', 'max-age=3600')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
                'cache-control' => ['max-age=3600'],
            ]);

        $this->shouldThrow('InvalidArgumentException')
            ->duringWithAddedHeader('', 'max-age=3200');

        $this->shouldThrow('InvalidArgumentException')
            ->duringWithAddedHeader('Cache-Control', new \stdClass());
    }

    function it_returns_instance_without_header() {
        $this
            ->withoutHeader('accept')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
            ]);

        // If header didn't exist return original headers
        $this
            ->withoutHeader('Authorization')
            ->callOnWrappedObject('getHeaders')
            ->shouldReturn([
                'Content-Type' => ['text/html'], // text/html changed to array
                'Accept' => ['text/html', 'application/javascript'],
            ]);
    }

    function it_gets_the_body_of_a_message($body)
    {
        $this->getBody()->shouldReturn($body);
    }

    function it_gets_new_instance_with_replaced_body(StreamInterface $replacedBody)
    {
        $this
            ->withBody($replacedBody)
            ->callOnWrappedObject('getBody')
            ->shouldReturn($replacedBody);
    }
}
