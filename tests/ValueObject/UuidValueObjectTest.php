<?php

namespace Cohete\DDD\Tests\ValueObject;

use Cohete\DDD\ValueObject\UuidValueObject;
use PHPUnit\Framework\TestCase;
use InvalidArgumentException;
use Ramsey\Uuid\Uuid;

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
}
