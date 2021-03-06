<?php

namespace SmoothCode\Sample\Domain\ExchangeRate\Event;

use Ramsey\Uuid\Uuid;
use SmoothCode\Sample\Domain\ExchangeRate\Currency;
use EventSauce\EventSourcing\Serialization\SerializablePayload;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateId;

class ExchangeRateCreated implements SerializablePayload {

    private ExchangeRateId $exchangeRateId;

    private Currency $sourceCurrency;

    private Currency $targetCurrency;

    private float $rate;

    /**
     * ExchangeRateCreated constructor.
     * @param ExchangeRateId $exchangeRateId
     * @param Currency $sourceCurrency
     * @param Currency $targetCurrency
     * @param float $rate
     */
    public function __construct(ExchangeRateId $exchangeRateId, Currency $sourceCurrency, Currency $targetCurrency, float $rate)
    {
        $this->exchangeRateId = $exchangeRateId;
        $this->sourceCurrency = $sourceCurrency;
        $this->targetCurrency = $targetCurrency;
        $this->rate           = $rate;
    }

    /**
     * @return ExchangeRateId
     */
    public function getId(): ExchangeRateId
    {
        return $this->exchangeRateId;
    }

    /**
     * @return Currency
     */
    public function getSourceCurrency(): Currency
    {
        return $this->sourceCurrency;
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

    /**
     * @return array
     */
    public function toPayload(): array
    {
        return [
            'sourceCurrency' => (string) $this->sourceCurrency,
            'targetCurrency' => (string) $this->targetCurrency,
            'rate' => $this->rate
        ];
    }

    /**
     * @param array $payload
     * @return SerializablePayload
     * @throws \Exception
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new self(
            ExchangeRateId::generate(),
            new Currency($payload['sourceCurrency']),
            new Currency($payload['targetCurrency']),
            $payload['rate']
        );
    }
}
