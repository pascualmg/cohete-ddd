<?php

namespace Cohete\DDD\Tests\ValueObject;

use Cohete\DDD\ValueObject\StringValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class TestStringVO extends StringValueObject
{
}

class StringValueObjectTest extends TestCase
{
    public function testFromCreatesInstanceWithValue(): void
    {
        $value = "test value";
        $vo = TestStringVO::from($value);
        $this->assertEquals($value, $vo->value);
    }

    public function testFromWithNullCreatesInstanceWithEmptyString(): void
    {
        $vo = TestStringVO::from(null);
        $this->assertEquals("", $vo->value);
    }

    public function testIsEmptyReturnsTrueForEmpty(): void
    {
        $vo = TestStringVO::from("");
        $this->assertTrue($vo->isEmpty());
    }

    public function testIsEmptyReturnsFalseForNonEmpty(): void
    {
        $vo = TestStringVO::from("not empty");
        $this->assertFalse($vo->isEmpty());
    }

    public function testToStringReturnsTheValue(): void
    {
        $value = "test value";
        $vo = TestStringVO::from($value);
        $this->assertEquals($value, (string)$vo);
    }

    public function testAssertMaxLengthPassesWhenWithinLimit(): void
    {
        TestStringVO::assertMaxLength(10, "12345");
        $this->assertTrue(true); // If no exception thrown, it passes
    }

    public function testAssertMaxLengthThrowsExceptionWhenExceeded(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Max length 5 exceeded (6 chars) in Cohete\DDD\Tests\ValueObject\TestStringVO");
        TestStringVO::assertMaxLength(5, "123456");
    }

    public function testAssertNotNullPassesForNonNull(): void
    {
        TestStringVO::assertNotNull("not null");
        $this->assertTrue(true);
    }

    public function testAssertNotNullThrowsForNull(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be null in Cohete\DDD\Tests\ValueObject\TestStringVO");
        TestStringVO::assertNotNull(null);
    }

    public function testAssertNotEmptyPassesForNonEmpty(): void
    {
        TestStringVO::assertNotEmpty("not empty");
        $this->assertTrue(true);
    }

    public function testAssertNotEmptyThrowsForEmpty(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty in Cohete\DDD\Tests\ValueObject\TestStringVO");
        TestStringVO::assertNotEmpty("");
    }

    public function testAssertNotEmptyThrowsForWhitespace(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value cannot be empty in Cohete\DDD\Tests\ValueObject\TestStringVO");
        TestStringVO::assertNotEmpty("   ");
    }
}
