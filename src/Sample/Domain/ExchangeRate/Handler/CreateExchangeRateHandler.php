<?php

namespace SmoothCode\Sample\Domain\ExchangeRate\Handler;

use SmoothCode\Sample\Domain\ExchangeRate\Command\CreateExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateId;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;

class CreateExchangeRateHandler {

    private ExchangeRateRepository $exchangeRateRepository;

    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    public function __invoke(CreateExchangeRate $command): void
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
