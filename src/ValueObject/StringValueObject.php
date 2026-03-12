<?php

namespace Cohete\DDD\ValueObject;

use Stringable;

abstract class StringValueObject implements Stringable
{
    final protected function __construct(public readonly string $value)
    {
    }

    public static function from(?string $value = null): static
    {
        return new static($value ?? "");
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value && static::class === $other::class;
    }

    public function isEmpty(): bool
    {
        return $this->value === "";
    }

    public function __toString(): string
    {
        return $this->value;
    }

    public static function assertMinLength(int $minLength, string $value): void
    {
        $currLength = mb_strlen($value);

        if ($currLength < $minLength) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Min length %d not reached (%d chars) in %s",
                    $minLength,
                    $currLength,
                    static::class
                )
            );
        }
    }

    public static function assertMaxLength(int $maxLength, string $value): void
    {
        $currLength = mb_strlen($value);

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

    /**
     * @phpstan-assert string $value
     */
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

    /**
     * @phpstan-assert !empty $value
     */
    public static function assertNotEmpty(?string $value): void
    {
        if ($value === null || empty(trim($value))) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Value cannot be empty in %s",
                    static::class
                )
            );
        }
    }
}
