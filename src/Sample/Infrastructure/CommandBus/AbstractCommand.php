<?php declare(strict_types=1);


namespace CurrencX\Infrastructure\CommandBus;

use Utils\Immutable\Immutable;

/**
 * Class AbstractCommand
 * @package CurrencX\Infrastructure\CommandBus
 *
 * @TODO: Handle fromPayload && toPayload methods with reflection
 */
abstract class AbstractCommand implements Command
{
    use Immutable;

    /**
     * @var array
     */
    protected array $payload = [];

    private function __construct(array $payload = [])
    {
        $this->payload = $payload;
    }

    public static function fromPayload(array $payload): Command
    {
        return new static($payload);
    }

    public function with(string $key, $value = null): Command
    {
        return new static(array_merge($this->payload, [
            $key => $value,
        ]));
    }

    public function without(string $key): Command
    {
        $payload = $this->payload;
        unset($payload[$key]);

        return new static($payload);
    }

    public function get(string $key, $defaultValue = null)
    {
        if (!array_key_exists($key, $this->payload)) {
            return $defaultValue;
        }

        return $this->payload[$key];
    }

    public function toPayload(): array
    {
        return $this->payload;
    }
}
