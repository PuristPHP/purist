<?php

namespace Purist\Message;

use InvalidArgumentException;
use Psr\Http\Message\MessageInterface;
use Psr\Http\Message\StreamInterface;

final class HttpMessage implements MessageInterface
{
    /**
     * @type string
     */
    private $protocolVersion;
    /**
     * @type array
     */
    private $headers;
    /**
     * @type StreamInterface
     */
    private $body;

    public function __construct($protocolVersion, array $headers, StreamInterface $body)
    {
        $this->protocolVersion = $protocolVersion;
        $this->headers = $headers;
        $this->body = $body;
    }

    /**
     * Retrieves the HTTP protocol version as a string.
     *
     * The string MUST contain only the HTTP version number (e.g., "1.1", "1.0").
     *
     * @return string HTTP protocol version.
     */
    public function getProtocolVersion()
    {
        return $this->protocolVersion;
    }

    /**
     * Return an instance with the specified HTTP protocol version.
     *
     * The version string MUST contain only the HTTP version number (e.g.,
     * "1.1", "1.0").
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new protocol version.
     *
     * @param string $version HTTP protocol version
     * @return self
     */
    public function withProtocolVersion($version)
    {
        return new self($version, $this->headers, $this->body);
    }

    /**
     * Retrieves all message header values.
     *
     * The keys represent the header name as it will be sent over the wire, and
     * each value is an array of strings associated with the header.
     *
     *     // Represent the headers as a string
     *     foreach ($message->getHeaders() as $name => $values) {
     *         echo $name . ": " . implode(", ", $values);
     *     }
     *
     *     // Emit headers iteratively:
     *     foreach ($message->getHeaders() as $name => $values) {
     *         foreach ($values as $value) {
     *             header(sprintf('%s: %s', $name, $value), false);
     *         }
     *     }
     *
     * While header names are not case-sensitive, getHeaders() will preserve the
     * exact case in which headers were originally specified.
     *
     * @return array Returns an associative array of the message's headers. Each
     *     key MUST be a header name, and each value MUST be an array of strings
     *     for that header.
     */
    public function getHeaders()
    {
        return array_map(function($item) {
            return (array) $item;
        }, $this->headers);
    }

    /**
     * Checks if a header exists by the given case-insensitive name.
     *
     * @param string $name Case-insensitive header field name.
     * @return bool Returns true if any header names match the given header
     *     name using a case-insensitive string comparison. Returns false if
     *     no matching header name is found in the message.
     */
    public function hasHeader($name)
    {
        return array_key_exists(
            strtolower($name),
            array_change_key_case($this->headers, CASE_LOWER)
        );
    }

    /**
     * Retrieves a message header value by the given case-insensitive name.
     *
     * This method returns an array of all the header values of the given
     * case-insensitive header name.
     *
     * If the header does not appear in the message, this method MUST return an
     * empty array.
     *
     * @param string $name Case-insensitive header field name.
     * @return string[] An array of string values as provided for the given
     *    header. If the header does not appear in the message, this method MUST
     *    return an empty array.
     */
    public function getHeader($name)
    {
        if (!$this->hasHeader($name)) {
            return [];
        }

        return (array) array_change_key_case($this->headers, CASE_LOWER)[strtolower($name)];
    }

    /**
     * Retrieves a comma-separated string of the values for a single header.
     *
     * This method returns all of the header values of the given
     * case-insensitive header name as a string concatenated together using
     * a comma.
     *
     * NOTE: Not all header values may be appropriately represented using
     * comma concatenation. For such headers, use getHeader() instead
     * and supply your own delimiter when concatenating.
     *
     * If the header does not appear in the message, this method MUST return
     * an empty string.
     *
     * @param string $name Case-insensitive header field name.
     * @return string A string of values as provided for the given header
     *    concatenated together using a comma. If the header does not appear in
     *    the message, this method MUST return an empty string.
     */
    public function getHeaderLine($name)
    {
        return implode(',', $this->getHeader($name));
    }

    /**
     * Return an instance with the provided value replacing the specified header.
     *
     * While header names are case-insensitive, the casing of the header will
     * be preserved by this function, and returned from getHeaders().
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new and/or updated header and value.
     *
     * @param string $name Case-insensitive header field name.
     * @param string|string[] $value Header value(s).
     * @return self
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withHeader($name, $value)
    {
        $this->guardHeaderName($name);
        $this->guardHeaderValue($value);

        return new self(
            $this->protocolVersion,
            array_merge(
                $this->withoutHeader($name)->getHeaders(),
                [
                    $name => array_merge(
                        $this->getHeader($name),
                        (array) $value
                    ),
                ]
            ),
            $this->body
        );
    }

    /**
     * Return an instance with the specified header appended with the given value.
     *
     * Existing values for the specified header will be maintained. The new
     * value(s) will be appended to the existing list. If the header did not
     * exist previously, it will be added.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that has the
     * new header and/or value.
     *
     * @param string $name Case-insensitive header field name to add.
     * @param string|string[] $value Header value(s).
     * @return self
     * @throws \InvalidArgumentException for invalid header names or values.
     */
    public function withAddedHeader($name, $value)
    {
        $this->guardHeaderName($name);
        $this->guardHeaderValue($value);

        if (!$this->hasHeader($name)) {
            return $this->withHeader($name, $value);
        }

        return new self(
            $this->protocolVersion,
            array_merge(
                $this->headers,
                array_map(
                    function ($item) use ($value) {
                        return array_merge($item, (array) $value);
                    },
                    array_filter(
                        $this->headers,
                        function($key) use ($name) {
                            return strtolower($key) === strtolower($name);
                        },
                        ARRAY_FILTER_USE_KEY
                    )
                )
            ),
            $this->body
        );
    }

    /**
     * Return an instance without the specified header.
     *
     * Header resolution MUST be done without case-sensitivity.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return an instance that removes
     * the named header.
     *
     * @param string $name Case-insensitive header field name to remove.
     * @return self
     */
    public function withoutHeader($name)
    {
        return new self(
            $this->protocolVersion,
            array_filter(
                $this->headers,
                function($header) use ($name) {
                    return strtolower($name) !== strtolower($header);
                },
                ARRAY_FILTER_USE_KEY
            ),
            $this->body
        );
    }

    /**
     * Gets the body of the message.
     *
     * @return StreamInterface Returns the body as a stream.
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Return an instance with the specified message body.
     *
     * The body MUST be a StreamInterface object.
     *
     * This method MUST be implemented in such a way as to retain the
     * immutability of the message, and MUST return a new instance that has the
     * new body stream.
     *
     * @param StreamInterface $body Body.
     * @return self
     * @throws \InvalidArgumentException When the body is not valid.
     */
    public function withBody(StreamInterface $body)
    {
        return new self($this->protocolVersion, $this->headers, $body);
    }

    /**
     * @param string $name
     * @throws \InvalidArgumentException When header name is invalid
     */
    private function guardHeaderName($name)
    {
        if (!is_string($name) || $name === '') {
            throw new InvalidArgumentException(
                'Name needs to be a non-empty string'
            );
        }
    }

    /**
     * @param string|string[] $value
     * @throws \InvalidArgumentException When header value is invalid
     */
    private function guardHeaderValue($value)
    {
        if (!is_string($value) && !is_array($value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Value needs to be a string or array, %s received',
                    gettype($value)
                )
            );
        }
    }
}
