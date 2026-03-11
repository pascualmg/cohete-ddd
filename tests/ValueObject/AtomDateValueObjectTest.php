<?php

namespace Cohete\DDD\Tests\ValueObject;

use Cohete\DDD\ValueObject\AtomDateValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use DateTimeImmutable;
use DateTimeInterface;

class TestAtomDateVO extends AtomDateValueObject
{
}

class AtomDateValueObjectTest extends TestCase
{
    public function testFromWithValidAtomDate(): void
    {
        $atomStr = (new DateTimeImmutable())->format(DateTimeInterface::ATOM);
        $vo = TestAtomDateVO::from($atomStr);
        $this->assertEquals($atomStr, $vo->value);
    }

    public function testFromThrowsForInvalidFormat(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Invalid Atom date format");
        TestAtomDateVO::from("2023-10-27 10:00:00");
    }

    public function testFromWithNullThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be null in Cohete\DDD\Tests\ValueObject\TestAtomDateVO");
        TestAtomDateVO::from(null);
    }

    public function testFromWithEmptyStringThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty in Cohete\DDD\Tests\ValueObject\TestAtomDateVO");
        TestAtomDateVO::from("");
    }

    public function testNowReturnsValidInstance(): void
    {
        $vo = TestAtomDateVO::now();
        $this->assertInstanceOf(TestAtomDateVO::class, $vo);
        // Checking if it follows ATOM format via regex as the class does
        $this->assertMatchesRegularExpression('/^(\d{4})-(\d{2})-(\d{2})T(\d{2}):(\d{2}):(\d{2})(.\d+)?(Z|([+\-])\d{2}:\d{2})$/', $vo->value);
    }

    public function testGetDatetimeImmutableReturnsDateTimeImmutable(): void
    {
        $atomStr = "2023-10-27T10:00:00+00:00";
        $vo = TestAtomDateVO::from($atomStr);
        $dt = $vo->getDatetimeImmutable();
        $this->assertInstanceOf(DateTimeImmutable::class, $dt);
        $this->assertEquals($atomStr, $dt->format(DateTimeInterface::ATOM));
    }
}
