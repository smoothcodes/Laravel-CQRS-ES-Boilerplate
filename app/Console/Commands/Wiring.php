<?php

namespace App\Console\Commands;

use CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer\CurrencyLayerCurrencyAdapter;
use CurrencX\Application\CurrencyRate\Adapter\CurrencyLayer\GetRateRequest;
use CurrencX\Domain\ExchangeRate\Currency;
use CurrencX\Domain\ExchangeRate\ExchangeRate;
use CurrencX\Domain\ExchangeRate\ExchangeRateId;
use CurrencX\Domain\ExchangeRate\ExchangeRateRepository;
use Illuminate\Console\Command;

class Wiring extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'wiring';

    /**
     * @var ExchangeRateRepository
     */
    protected ExchangeRateRepository $exchangeRateRepository;

    /**
     * Create a new command instance.
     *
     * @param ExchangeRateRepository $exchangeRateRepository
     */
    public function __construct(ExchangeRateRepository $exchangeRateRepository)
    {
        parent::__construct();
        $this->exchangeRateRepository = $exchangeRateRepository;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $id = ExchangeRateId::generate();

        $currencyClient = new CurrencyLayerCurrencyAdapter();
        $rate = $currencyClient->getRate('EUR', 'PLN');

        dump($rate);
        $exchangeRate = ExchangeRate::create(
            $id,
            Currency::EUR(),
            Currency::PLN(),
            $rate
        );
//
////        dump($exchangeRate);
//
        $this->exchangeRateRepository->save($exchangeRate);
        /** @var ExchangeRateId $rateId */
//        $rateId = ExchangeRateId::fromString('fd687aa4-183f-11ea-bf7b-588a5a2101d4');
//        dump($this->exchangeRateRepository->find($rateId));

        return 1;
    }
}
