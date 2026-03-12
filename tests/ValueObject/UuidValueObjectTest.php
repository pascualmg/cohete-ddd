<?php

namespace Cohete\DDD\Tests\ValueObject;

use Cohete\DDD\ValueObject\UuidValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

class TestUuidVO extends UuidValueObject
{
}

class AnotherUuidVO extends UuidValueObject
{
}

class UuidValueObjectTest extends TestCase
{
    public function testFromWithValidUuidString(): void
    {
        $uuidStr = Uuid::uuid4()->toString();
        $vo = UuidValueObject::from($uuidStr);
        $this->assertEquals($uuidStr, $vo->value);
    }

    public function testFromThrowsForInvalidUuid(): void
    {
        $this->expectException(InvalidArgumentException::class);
        UuidValueObject::from("invalid-uuid");
    }

    public function testV4GeneratesValidUuid(): void
    {
        $vo = UuidValueObject::v4();
        $this->assertTrue(Uuid::isValid($vo->value));
    }

    public function testToStringReturnsUuidString(): void
    {
        $uuidStr = Uuid::uuid4()->toString();
        $vo = UuidValueObject::from($uuidStr);
        $this->assertEquals($uuidStr, (string)$vo);
    }

    public function testEqualsSameUuid(): void
    {
        $uuidStr = Uuid::uuid4()->toString();
        $vo1 = UuidValueObject::from($uuidStr);
        $vo2 = UuidValueObject::from($uuidStr);
        $this->assertTrue($vo1->equals($vo2));
    }

    public function testEqualsDifferentUuid(): void
    {
        $vo1 = UuidValueObject::v4();
        $vo2 = UuidValueObject::v4();
        $this->assertFalse($vo1->equals($vo2));
    }

    public function testEqualsDifferentTypeSameUuid(): void
    {
        $uuidStr = Uuid::uuid4()->toString();
        $vo1 = TestUuidVO::from($uuidStr);
        $vo2 = AnotherUuidVO::from($uuidStr);
        $this->assertFalse($vo1->equals($vo2));
    }
}
