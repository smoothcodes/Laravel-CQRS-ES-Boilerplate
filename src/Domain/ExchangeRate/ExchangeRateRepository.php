<?php declare(strict_types=1);

namespace CurrencX\Domain\ExchangeRate;

interface ExchangeRateRepository
{
    public function find(ExchangeRateId $itemId): ExchangeRate;

    public function save(ExchangeRate $item): void;
}
