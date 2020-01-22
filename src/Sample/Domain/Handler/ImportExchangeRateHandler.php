<?php

namespace SmoothCode\Sample\Domain\Handler;

use SmoothCode\Sample\Domain\Command\ImportExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateId;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;

class ImportExchangeRateHandler {

    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function __invoke(ImportExchangeRate $command): void
    {
        $exchangeRate = ExchangeRate::create(
            ExchangeRateId::generate(),
            $command->getSourceCurrency(),
            $command->getTargetCurrency(),
            $command->getRate()
        );

        $this->exchangeRateRepository->save($exchangeRate);
    }
}
