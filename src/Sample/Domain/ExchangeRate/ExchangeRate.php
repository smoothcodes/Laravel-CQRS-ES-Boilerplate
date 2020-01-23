<?php

namespace SmoothCode\Sample\Domain\ExchangeRate;

use SmoothCode\Sample\Domain\ExchangeRate\Event\ExchangeRateCreated;
use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use Webmozart\Assert\Assert;

class ExchangeRate implements AggregateRoot
{
    use AggregateRootBehaviour;

    protected Currency $sourceCurrency;

    protected Currency $targetCurrency;

    protected float $rate;

    public static function create(
        ExchangeRateId $exchangeRateId,
        Currency $sourceCurrency,
        Currency $targetCurrency,
        float $rate
    ) {
        Assert::notEq($sourceCurrency, $targetCurrency);

        $exchangeRate = new static($exchangeRateId);
        $exchangeRate->recordThat(
            new ExchangeRateCreated(
                $exchangeRateId,
                $sourceCurrency,
                $targetCurrency,
                $rate
            )
        );

        return $exchangeRate;
    }

    protected function applyExchangeRateCreated(ExchangeRateCreated $exchangeRateCreated): void
    {
        $this->sourceCurrency = $exchangeRateCreated->getSourceCurrency();
        $this->targetCurrency = $exchangeRateCreated->getTargetCurrency();
        $this->rate           = $exchangeRateCreated = $exchangeRateCreated->getRate();
    }
}
