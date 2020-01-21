<?php declare(strict_types=1);

namespace CurrencX\Infrastructure\ExchangeRate;

use CurrencX\Domain\ExchangeRate\ExchangeRate;
use CurrencX\Domain\ExchangeRate\ExchangeRateId;
use CurrencX\Domain\ExchangeRate\ExchangeRateRepository;
use EventSauce\EventSourcing\AggregateRootRepository;

class EventSauceExchangeRateRepository implements ExchangeRateRepository
{
    /**
     * @var AggregateRootRepository
     */
    private AggregateRootRepository $aggregateRootRepository;

    public function __construct(AggregateRootRepository $aggregateRootRepository)
    {
        $this->aggregateRootRepository = $aggregateRootRepository;
    }

    public function find(ExchangeRateId $itemId): ExchangeRate
    {
        /** @var ExchangeRate $exchangeRate */
        $exchangeRate = $this->aggregateRootRepository->retrieve($itemId);

        return $exchangeRate;
    }

    public function save(ExchangeRate $item): void
    {
        $this->aggregateRootRepository->persist($item);
    }

}
