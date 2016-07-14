<?php

namespace spec\Purist\Request;

use PhpSpec\ObjectBehavior;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;
use Purist\Request\Request;

class RequestSpec extends ObjectBehavior
{
    function let(MessageInterface $httpMessage, UriInterface $uri)
    {
        $this->beConstructedWith($httpMessage, $uri, 'GET', 'origin-form');
    }

    function it_is_initializable()
    {
        $this->shouldHaveType('Purist\Request\Request');
        $this->shouldImplement('Psr\Http\Message\RequestInterface');
    }

    function it_gets_headers(MessageInterface $httpMessage)
    {
        $httpMessage->getHeaders()->willReturn(
            [
                'Content-Type' => ['text/html'],
                'X-ua-Compatible:IE' => ['Edge', 'chrome=1'],
            ]
        );

        $this->getHeaders()->shouldReturn(
            [
                'Content-Type' => ['text/html'],
                'X-ua-Compatible:IE' => ['Edge', 'chrome=1'],
            ]
        );
    }

    function it_gets_protocol_version(MessageInterface $httpMessage)
    {
        $httpMessage->getProtocolVersion()->willReturn('1.1');
        $this->getProtocolVersion()->shouldReturn('1.1');
    }

    function it_returns_an_instance_with_changed_protocol_version(MessageInterface $httpMessage)
    {
        $httpMessage->getProtocolVersion()->willReturn('1.0');
        $httpMessage->withProtocolVersion('1.0')->willReturn(
            $httpMessage
        );

        $this
            ->withProtocolVersion('1.0')
            ->callOnWrappedObject('getProtocolVersion')
            ->shouldReturn('1.0');
    }

    function it_checks_for_header(MessageInterface $httpMessage)
    {
        $httpMessage->hasHeader('Content-Type')->willReturn(true);
        $httpMessage->hasHeader('Content-Encoding')->willReturn(false);
        $this->hasHeader('Content-Type')->shouldReturn(true);
        $this->hasHeader('Content-Encoding')->shouldReturn(false);
    }

    function it_gets_header(MessageInterface $httpMessage)
    {
        $httpMessage->getHeader('Content-Type')->willReturn(['text/html']);
        $httpMessage->getHeader('Content-Encoding')->willReturn([]);
        $this->getHeader('Content-Type')->shouldReturn(['text/html']);
        $this->getHeader('Content-Encoding')->shouldReturn([]);
    }

    function it_gets_header_values_as_comma_separated_string(MessageInterface $httpMessage)
    {
        $httpMessage->getHeaderLine('Accept')->willReturn('text/html,application/javascript');
        $httpMessage->getHeaderLine('Content-Encoding')->willReturn('');
        $this->getHeaderLine('Accept')->shouldReturn('text/html,application/javascript');
        $this->getHeaderLine('Content-Encoding')->shouldReturn('');
    }

    function it_returns_instance_with_replaced_header(MessageInterface $httpMessage)
    {
        $httpMessage->getHeader('Content-Type')->willReturn('text/html');
        $httpMessage->withHeader('Content-Type', 'text/html')->willReturn($httpMessage);
        $this
            ->withHeader('Content-Type', 'text/html')
            ->callOnWrappedObject('getHeader', ['Content-Type'])
            ->shouldReturn('text/html');
    }

    function it_returns_instance_with_appended_header_value(MessageInterface $httpMessage)
    {
        $httpMessage->getHeader('Accept')->willReturn(['application/javascript', 'text/html']);
        $httpMessage->withAddedHeader('Accept', 'text/html')->willReturn($httpMessage);

        $this
            ->withAddedHeader('Accept', 'text/html')
            ->callOnWrappedObject('getHeader', ['Accept'])
            ->shouldReturn(['application/javascript', 'text/html']);
    }

    function it_returns_instance_without_header(MessageInterface $httpMessage)
    {
        $httpMessage->getHeader('Accept')->willReturn([]);
        $httpMessage->withoutHeader('Accept')->willReturn($httpMessage);

        $this
            ->withoutHeader('Accept')
            ->callOnWrappedObject('getHeader', ['Accept'])
            ->shouldReturn([]);
    }

    function it_gets_body_of_message(MessageInterface $httpMessage, StreamInterface $body)
    {
        $httpMessage->getBody()->willReturn($body);
        $this->getBody()->shouldReturn($body);
    }

    function it_returns_instance_with_replaced_body(MessageInterface $httpMessage, StreamInterface $body)
    {
        $httpMessage->getBody()->willReturn($body);
        $httpMessage->withBody($body)->willReturn($httpMessage);

        $this
            ->withBody($body)
            ->callOnWrappedObject('getBody')
            ->shouldReturn($body);
    }

    function it_gets_the_request_target(UriInterface $uri)
    {
        $uri->getPath()->willReturn('/path');
        $uri->getQuery()->willReturn('query=1');
        $this->getRequestTarget()->shouldReturn('/path?query=1');

        $uri->getPath()->willReturn('');
        $uri->getQuery()->willReturn('');
        $this->getRequestTarget()->shouldReturn('/');

        $uri->getPath()->willReturn('');
        $uri->getQuery()->willReturn('query=1');
        $this->getRequestTarget()->shouldReturn('/?query=1');
    }

    function it_returns_instance_with_changed_request_target()
    {
        $this
            ->withRequestTarget('*')
            ->callOnWrappedObject('getRequestTarget')
            ->shouldReturn('*');
    }

    function it_gets_default_request_method($httpMessage, $uri)
    {
        $this->beConstructedWith($httpMessage, $uri);
        $this->getMethod()->shouldReturn('GET');
    }

    function it_gets_custom_request_method($httpMessage, $uri)
    {
        $this->beConstructedWith($httpMessage, $uri, 'POST');
        $this->getMethod()->shouldReturn('POST');
    }

    function it_returns_instance_with_changed_method()
    {
        $this
            ->withMethod('PUT')
            ->callOnWrappedObject('getMethod')
            ->shouldReturn('PUT');
    }

    function it_returns_clone_of_uri($uri)
    {
        $this->getUri()->shouldReturn($uri);
    }

    function it_returns_instance_with_changed_uri(UriInterface $newUri)
    {
        $this
            ->withUri($newUri)
            ->callOnWrappedObject('getUri')
            ->shouldReturn($newUri);
    }
}
