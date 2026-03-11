<?php

namespace Cohete\DDD\ValueObject;

class AtomDateValueObject extends StringValueObject
{
    public static function from(?string $value = null): static
    {
        static::assertNotNull($value);
        static::assertNotEmpty($value);

        static::assertHasCorrectDatetimeInterfaceAtomFormat($value);
        return parent::from($value);
    }

    protected static function assertHasCorrectDatetimeInterfaceAtomFormat(string $value): void
    {
        if (!preg_match('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.\d+)?(Z|([+\-])\d{2}:\d{2})$/', $value)) {
            throw new \InvalidArgumentException(
                sprintf(
                    "Invalid Atom date format, used %s  , example : %s",
                    $value,
                    (new \DateTimeImmutable('now'))->format(\DateTimeInterface::ATOM)
                )
            );
        }
    }

    public function getDatetimeImmutable(): \DateTimeImmutable
    {
        return new \DateTimeImmutable($this->value);
    }

    public static function now(): static
    {
        return static::from((new \DateTimeImmutable('now'))->format(\DateTimeInterface::ATOM));
    }
}
