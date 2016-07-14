<?php

declare(strict_types=1);

namespace Purist\Message;

use InvalidArgumentException;

class ValidHeader
{
    private $name;
    private $value;

    /**
     * @param string $name
     * @param string|string[] $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     * @throws \InvalidArgumentException
     */
    public function name(): string
    {
        if (!is_string($this->name) || $this->name === '') {
            throw new InvalidArgumentException(
                sprintf(
                    'Name needs to be a non-empty string, %s received',
                    gettype($this->name)
                )
            );
        }

        return $this->name;
    }

    /**
     * @return string|string[]
     * @throws \InvalidArgumentException
     */
    public function value()
    {
        if (!is_string($this->value) && !is_array($this->value)) {
            throw new InvalidArgumentException(
                sprintf(
                    'Value needs to be a string or array, %s received',
                    gettype($this->value)
                )
            );
        }

        return $this->value;
    }
}
