<?php

namespace SmoothCode\Sample\Domain\Command;

use SmoothCode\Propagation\AbstractCommand;
use SmoothCode\Propagation\Command;
use SmoothCode\Sample\Domain\ExchangeRate\Currency;

class ImportExchangeRate extends AbstractCommand {

    const SOURCE_CURRENCY = 'sourceCurrency';
    const TARGET_CURRENCY = 'targetCurrency';
    const RATE = 'rate';

    protected static array $requiredFields = [
        self::SOURCE_CURRENCY,
        self::TARGET_CURRENCY,
        self::RATE
    ];

    private Currency $sourceCurrency;
    private Currency $targetCurrency;
    private float $rate;

    public function getSourceCurrency() {
        return $this->sourceCurrency;
    }

    public function getTargetCurrency() {
        return $this->targetCurrency;
    }

    public function getRate() {
        return $this->rate;
    }
}
