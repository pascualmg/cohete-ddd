<?php

namespace Cohete\DDD\Tests\ValueObject;

use Cohete\DDD\ValueObject\IntValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;

class TestIntVO extends IntValueObject
{
}

class AnotherIntVO extends IntValueObject
{
}

class IntValueObjectTest extends TestCase
{
    public function testFromCreatesInstance(): void
    {
        $vo = TestIntVO::from(42);
        $this->assertEquals(42, $vo->value);
    }

    public function testFromWithZero(): void
    {
        $vo = TestIntVO::from(0);
        $this->assertEquals(0, $vo->value);
    }

    public function testFromWithNegative(): void
    {
        $vo = TestIntVO::from(-5);
        $this->assertEquals(-5, $vo->value);
    }

    public function testEqualsSameValue(): void
    {
        $vo1 = TestIntVO::from(42);
        $vo2 = TestIntVO::from(42);
        $this->assertTrue($vo1->equals($vo2));
    }

    public function testEqualsDifferentValue(): void
    {
        $vo1 = TestIntVO::from(42);
        $vo2 = TestIntVO::from(99);
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testEqualsDifferentTypeSameValue(): void
    {
        $vo1 = TestIntVO::from(42);
        $vo2 = AnotherIntVO::from(42);
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testAssertMinPasses(): void
    {
        TestIntVO::assertMin(0, 5);
        $this->assertTrue(true);
    }

    public function testAssertMinThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value -1 is below minimum 0");
        TestIntVO::assertMin(0, -1);
    }

    public function testAssertMaxPasses(): void
    {
        TestIntVO::assertMax(100, 50);
        $this->assertTrue(true);
    }

    public function testAssertMaxThrows(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage("Value 101 exceeds maximum 100");
        TestIntVO::assertMax(100, 101);
    }
}
