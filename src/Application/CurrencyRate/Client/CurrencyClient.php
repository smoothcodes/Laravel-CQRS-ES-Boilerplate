<?php

namespace CurrencX\Application\CurrencyRate\Client;

use Money\Money;

interface CurrencyClient {
    public function getRate(string $baseCurrency, string $targetCurrency): float;
}
