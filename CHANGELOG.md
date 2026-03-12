# Changelog

## [0.1.0] - 2026-03-12

### Added
- `StringValueObject` (abstract) with `equals()`, `assertMinLength`, `assertMaxLength`, `assertNotNull`, `assertNotEmpty`
- `UuidValueObject` with `equals()` (compares value and type)
- `AtomDateValueObject` extending `StringValueObject` with ATOM format validation
- `IntValueObject` (abstract) with `equals()`, `assertMin`, `assertMax`
- `AggregateRoot` base class with `record(DomainEvent)` and `pullDomainEvents()`
- `DomainEvent` minimal interface (`eventName`, `payload`, `occurredOn`)
- PHPUnit tests (44 tests, 60 assertions)
- PHPStan max level analysis
- GitHub Actions CI (PHP 8.2 + 8.3)
