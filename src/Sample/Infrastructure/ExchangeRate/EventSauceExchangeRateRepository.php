<?php declare(strict_types=1);

namespace SmoothCode\Sample\Infrastructure\ExchangeRate;

use SmoothCode\Sample\Domain\ExchangeRate\EchoWhenImported;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateId;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;
use EventSauce\EventSourcing\AggregateRootRepository;
use SmoothCode\Sample\Infrastructure\EventSourcing\AggregateRootRepositoryFactory;

class EventSauceExchangeRateRepository implements ExchangeRateRepository
{
    /** @var string[] */
    protected array $consumers = [
        EchoWhenImported::class
    ];

    protected array $eventConsumers = [

    ];

    /**
     * @var AggregateRootRepositoryFactory
     */
    private AggregateRootRepositoryFactory $aggregateRootRepositoryFactory;

    public function __construct(AggregateRootRepositoryFactory $aggregateRootRepositoryFactory)
    {
        $this->aggregateRootRepositoryFactory = $aggregateRootRepositoryFactory;
    }

    public function find(ExchangeRateId $itemId): ExchangeRate
    {
        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $this->aggregateRootRepository()->retrieve($itemId);

        return $exchangeRate;
    }

    public function save(ExchangeRate $item): void
    {
        $this->aggregateRootRepository()->persist($item);
    }

    private function aggregateRootRepository(): AggregateRootRepository
    {
        return $this->aggregateRootRepositoryFactory->create($this->consumers, $this->eventConsumers);
    }

}
