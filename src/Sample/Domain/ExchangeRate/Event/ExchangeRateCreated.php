<?php

namespace SmoothCode\Sample\Domain\ExchangeRate\Event;

use SmoothCode\Sample\Domain\ExchangeRate\Currency;
use EventSauce\EventSourcing\Serialization\SerializablePayload;

class ExchangeRateCreated implements SerializablePayload {

    private Currency $sourceCurrency;

    private Currency $targetCurrency;

    private float $rate;

    /**
     * ExchangeRateCreated constructor.
     * @param Currency $sourceCurrency
     * @param Currency $targetCurrency
     * @param float $rate
     */
    public function __construct(Currency $sourceCurrency, Currency $targetCurrency, float $rate)
    {
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->rate           = $rate;
    }

    /**
     * @return Currency
     */
    public function getSourceCurrency(): Currency
    {
        return $this->sourceCurrency;
    }

    /**
     * @param Currency $sourceCurrency
     */
    public function setSourceCurrency(Currency $sourceCurrency): void
    {
        $this->sourceCurrency = $sourceCurrency;
    }

    /**
     * @return Currency
     */
    public function getTargetCurrency(): Currency
    {
        return $this->targetCurrency;
    }

    /**
     * @param Currency $targetCurrency
     */
    public function setTargetCurrency(Currency $targetCurrency): void
    {
        $this->targetCurrency = $targetCurrency;
    }

    /**
     * @return float
     */
    public function getRate(): float
    {
        return $this->rate;
    }

    /**
     * @param float $rate
     */
    public function setRate(float $rate): void
    {
        $this->rate = $rate;
    }

    public function toPayload(): array
    {
        return [
            'sourceCurrency' => (string) $this->sourceCurrency,
            'targetCurrency' => (string) $this->targetCurrency,
            'rate' => $this->rate
        ];
    }

    public static function fromPayload(array $payload): SerializablePayload
    {
        return new self(
            new Currency($payload['sourceCurrency']),
            new Currency($payload['targetCurrency']),
            $payload['rate']
        );
    }
}
