# cohete/ddd

[![CI](https://github.com/pascualmg/cohete-ddd/actions/workflows/ci.yml/badge.svg)](https://github.com/pascualmg/cohete-ddd/actions/workflows/ci.yml)

Opinionated DDD building blocks for Cohete.

## Installation

```bash
composer require cohete/ddd
```

## Usage

### Custom Value Object with validation

You can create your own Value Objects by extending `StringValueObject` and adding validation in the `from()` method.

```php
use Cohete\DDD\ValueObject\StringValueObject;

class UserEmail extends StringValueObject
{
    public static function from(?string $value = null): static
    {
        static::assertNotNull($value);

        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new \InvalidArgumentException(sprintf('"%s" is not a valid email.', $value));
        }

        return parent::from($value);
    }
}
```

## Value Objects

- **StringValueObject**: A base class for string-based value objects with basic validation utilities.
- **AtomDateValueObject**: A value object for dates in ATOM format, extending `StringValueObject`.
- **UuidValueObject**: A value object for UUIDs using the `ramsey/uuid` library.

## License

This project is licensed under the MIT License.
