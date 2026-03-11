<?php

namespace Cohete\DDD\ValueObject;

use Stringable;

class StringValueObject implements Stringable
{
    protected function __construct(public readonly string $value)
    {
    }

    public static function from(?string $value = null): static
    {
        return new static($value ?? "");
    }

    public function isEmpty(): bool
    {
        return $this->value === "";
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function assertMaxLength(int $maxLength, string $value): void
    {
        $currLength = strlen($value);

        if ($currLength > $maxLength) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Max length %d exceeded (%d chars) in %s",
                    $maxLength,
                    $currLength,
                    static::class
                )
            );
        }
    }

    public static function assertNotNull(?string $value): void
    {
        if ($value === null) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Value cannot be null in %s",
                    static::class
                )
            );
        }
    }

    public static function assertNotEmpty(?string $value): void
    {
        if (empty(trim($value))) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Value cannot be empty in %s",
                    static::class
                )
            );
        }
    }
}
