<?php declare(strict_types=1);


namespace CurrencX\Infrastructure\CommandBus;

use Utils\Immutable\Immutable;

/**
 * Class AbstractCommand
 * @package CurrencX\Infrastructure\CommandBus
 *
 * @TODO: Handle toPayload method with reflection
 * @TODO: Check if fromPayload method works
 */
abstract class AbstractCommand implements Command
{
    use Immutable;

    protected static array $requiredFields = [

    ];

    public static function fromPayload(array $payload): Command
    {
        if (!self::validatePayaload($payload)){
            /** @TODO: create custom exception class */
            throw new \Exception('Invalid payload');
        }

        $command = new static();
        $reflection = new \ReflectionClass($command);
        foreach ($reflection->getProperties() as $property) {
            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }

            if (!array_key_exists($property->getName(), $payload)) {
                throw new \InvalidArgumentException(sprintf('Key [%s] do not exists in payload', $property->getName()));
            }

            $property->setValue($command, $payload[$property->getName()]);
        }

        return $command;
    }

    protected static function validatePayaload($payload): bool
    {
        return !(count(array_diff(self::$requiredFields, array_keys($payload))) > 0);
    }

//    public static function fromPayload(array $payload): Command
//    {
//        return new static($payload);
//    }
//
//    public function with(string $key, $value = null): Command
//    {
//        return new static(array_merge($this->payload, [
//            $key => $value,
//        ]));
//    }
//
//    public function without(string $key): Command
//    {
//        $payload = $this->payload;
//        unset($payload[$key]);
//
//        return new static($payload);
//    }
//
//    public function get(string $key, $defaultValue = null)
//    {
//        if (!array_key_exists($key, $this->payload)) {
//            return $defaultValue;
//        }
//
//        return $this->payload[$key];
//    }
//
//    public function toPayload(): array
//    {
//        return $this->payload;
//    }
}
