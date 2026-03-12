# Contributing to cohete/ddd

## Requirements

- PHP 8.2+
- Composer

## Setup

```bash
composer install
```

## Tests

```bash
composer test
```

## Static Analysis

```bash
composer analyse
```

## Project Structure

```
src/
  Aggregate/
    AggregateRoot.php       Base class: record() + pullDomainEvents()
  Event/
    DomainEvent.php         Minimal interface for domain events
  ValueObject/
    StringValueObject.php   Abstract base for string VOs
    UuidValueObject.php     UUID value object (ramsey/uuid)
    AtomDateValueObject.php ATOM format date VO
    IntValueObject.php      Abstract base for integer VOs
tests/
    Mirror of src/ structure
```

## Adding a New Value Object

1. Create a class extending the appropriate base (`StringValueObject`, `IntValueObject`, or `UuidValueObject`)
2. Add validation in the constructor or factory method
3. Write tests covering valid/invalid inputs and `equals()` behavior
4. Run `composer test && composer analyse`

## Pull Requests

- One feature per PR
- Tests required
- PHPStan must pass at max level
