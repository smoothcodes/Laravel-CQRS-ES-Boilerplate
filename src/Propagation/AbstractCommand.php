<?php declare(strict_types=1);


namespace SmoothCode\Propagation;

use Illuminate\Support\Collection;
use Utils\Immutable\Immutable;

/**
 * Class AbstractCommand
 * @package SmoothCode\Sample\Infrastructure\CommandBus
 *
 * @TODO: Handle toPayload method with reflection
 * @TODO: Check if fromPayload method works
 */
abstract class AbstractCommand implements Command
{
    protected static array $requiredFields = [];

    protected static array $allowedFields = [];

    /**
     * @param array $payload
     * @return Command
     * @throws \ReflectionException
     */
    public static function fromPayload(array $payload): Command
    {
        $payload = self::validatePayaload($payload);
        $command    = new static();
        $reflection = new \ReflectionClass($command);
        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

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

    /**
     * @return array
     * @throws \ReflectionException
     */
    public function toPayload(): array
    {
        $payload    = [];
        $reflection = new \ReflectionClass($this);
        foreach ($reflection->getProperties() as $property) {
            if ($property->isStatic()) {
                continue;
            }

            if (!$property->isPublic()) {
                $property->setAccessible(true);
            }

            $payload[$property->getName()] = $property->getValue($this);
        }

        return $payload;
    }

    protected static function validatePayaload($payload): array
    {
        $payloadKeys = array_keys($payload);
        if(count($missingFields = array_diff(static::$requiredFields, $payloadKeys)) > 0) {
            throw InvalidPayloadException::requiredFieldsNotSatisfied(...$missingFields);
        }

        $keysToRemove = array_diff($payloadKeys, static::$requiredFields + static::$allowedFields);
        foreach ($keysToRemove as $key) {
            unset($payload[$key]);
        }

        return $payload;
    }
}
