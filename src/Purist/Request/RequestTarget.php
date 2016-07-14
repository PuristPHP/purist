<?php

declare(strict_types = 1);

namespace Purist\Request;

use Psr\Http\Message\UriInterface;

final class RequestTarget
{
    const ORIGIN_FORM = 'origin-form';
    const ABSOLUTE_FORM = 'absolute-form';
    const AUTHORITY_FORM = 'authority-form';
    const ASTERISK_FORM = 'asterisk-form';

    private $requestTargetForm;
    private $uri;

    public function __construct(
        string $requestTargetForm = self::ORIGIN_FORM,
        UriInterface $uri
    ) {
        $this->requestTargetForm = $requestTargetForm;
        $this->uri = $uri;
    }

    public function toString(): string
    {
        switch ($this->requestTargetForm) {
            case self::ORIGIN_FORM:
                return $this->originForm();
            case self::ASTERISK_FORM:
                return '*';
            case self::ABSOLUTE_FORM:
                return $this->absoluteForm();
            case self::AUTHORITY_FORM:
                return $this->uri->getAuthority();
        }

        return $this->requestTargetForm;
    }

    private function originForm(): string
    {
        return implode(
            '?',
            array_filter(
                [
                    $this->uri->getPath() ?: '/',
                    $this->uri->getQuery(),
                ]
            )
        );
    }

    private function absoluteForm(): string
    {
        return implode(
            '',
            array_filter(
                [
                    $this->uri->getScheme() ? $this->uri->getScheme(
                        ) . '://' : false,
                    $this->uri->getAuthority(),
                    $this->uri->getPath(),
                    $this->uri->getQuery() ? '?' . $this->uri->getQuery(
                        ) : false,
                    $this->uri->getFragment() ? '#' . $this->uri->getFragment(
                        ) : false,
                ]
            )
        );
    }

    public function form(): string
    {
        return $this->requestTargetForm;
    }
}
