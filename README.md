# cohete/ddd

[![CI](https://github.com/pascualmg/cohete-ddd/actions/workflows/ci.yml/badge.svg)](https://github.com/pascualmg/cohete-ddd/actions/workflows/ci.yml)

Opinionated DDD building blocks for [Cohete](https://github.com/pascualmg/cohete-framework).

## Installation

```bash
composer require cohete/ddd
```

## Value Objects

- **StringValueObject** - Base class for string VOs with validation (maxLength, notNull, notEmpty)
- **UuidValueObject** - UUID v4 via ramsey/uuid
- **AtomDateValueObject** - Dates in ATOM format

### Example: custom Value Object

```php
use Cohete\DDD\ValueObject\StringValueObject;

class UserEmail extends StringValueObject
{
    public static function from(?string $value = null): static
    {
        static::assertNotNull($value);
        static::assertNotEmpty($value);
        static::assertMaxLength(255, $value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException("Invalid email: $value");
        }

        return parent::from($value);
    }
}
```

## License

MIT
