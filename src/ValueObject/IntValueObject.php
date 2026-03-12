<?php

namespace Cohete\DDD\ValueObject;

abstract class IntValueObject
{
    final protected function __construct(public readonly int $value)
    {
    }

    public static function from(int $value): static
    {
        return new static($value);
    }

    public function equals(self $other): bool
    {
        return $this->value === $other->value && static::class === $other::class;
    }

    public static function assertMin(int $min, int $value): void
    {
        if ($value < $min) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Value %d is below minimum %d in %s",
                    $value,
                    $min,
                    static::class
                )
            );
        }
    }

    public static function assertMax(int $max, int $value): void
    {
        if ($value > $max) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Value %d exceeds maximum %d in %s",
                    $value,
                    $max,
                    static::class
                )
            );
        }
    }
}
