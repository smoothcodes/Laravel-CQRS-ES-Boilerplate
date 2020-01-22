<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\ExchangeRate;

use EventSauce\EventSourcing\AggregateRootId;
use Ramsey\Uuid\Uuid;

class ExchangeRateId implements AggregateRootId
{

    /**
     * @var string
     */
    private string $uuid;

    /**
     * ExchangeRateId constructor.
     * @param string $uuid
     */
    private function __construct(string $uuid)
    {
        $this->uuid = $uuid;
    }

    /**
     * @return string
     */
    public function toString(): string
    {
        return $this->uuid;
    }

    /**
     * @param string $aggregateRootId
     * @return AggregateRootId
     */
    public static function fromString(string $aggregateRootId): AggregateRootId
    {
        return new self((string)Uuid::fromString($aggregateRootId));
    }

    /**
     * @return ExchangeRateId
     * @throws \Exception
     */
    public static function generate()
    {
        return new self((string)Uuid::uuid1());
    }

}
