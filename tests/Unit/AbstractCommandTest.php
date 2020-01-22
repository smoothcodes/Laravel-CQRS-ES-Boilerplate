<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;
use SmoothCode\Propagation\AbstractCommand;
use SmoothCode\Propagation\Command;

class AbstractCommandTest extends TestCase
{
    protected Command $abstractCommand;

    /**
     * @throws \ReflectionException
     * @covers AbstractCommand::fromPayload
     */
    public function testFromPayloadReturnsInstanceOfCommand()
    {
        $this->assertInstanceOf(
            Command::class,
            $this->abstractCommand::fromPayload(['name' => 'Jan', 'age' => 25])
        );
    }

    /**
     * @throws \ReflectionException
     * @covers AbstractCommand::fromPayload
     */
    public function testFromPayloadFieldsNotSatisfied()
    {
        $this->expectException(\Exception::class);

        $this->abstractCommand::fromPayload(['name' => 'Jan']);
    }

    /**
     * @throws \ReflectionException
     * @covers AbstractCommand::toPayload
     */
    public function testToPayloadReturnsProperArray()
    {
        $command = $this->abstractCommand::fromPayload(['name' => 'Jan', 'age' => 22]);
        $this->assertIsArray($command->toPayload());
    }

    /**
     * @throws \ReflectionException
     * @covers AbstractCommand::toPayload
     */
    public function testToPayloadHasProperKeys()
    {
        $command = $this->abstractCommand::fromPayload(['name' => 'Jan', 'age' => 22]);
        $this->assertArrayHasKey('name', $command->toPayload());
        $this->assertArrayHasKey('age', $command->toPayload());
    }

    /**
     * @throws \ReflectionException
     * @covers AbstractCommand::toPayload
     */
    public function testToPayloadGivesProperValues()
    {
        $command = $this->abstractCommand::fromPayload(['name' => 'Jan', 'age' => 22]);
        $this->assertEquals('Jan', $command->toPayload()['name']);
        $this->assertEquals(22, $command->toPayload()['age']);
    }

    protected function setUp(): void
    {
        $this->abstractCommand = new class extends AbstractCommand {
            protected static array $requiredFields = [
                'name',
                'age'
            ];

            public string $name;
            public string $age;
        };
    }
}
