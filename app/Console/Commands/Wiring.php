<?php

namespace App\Console\Commands;

use SmoothCode\Propagation\AbstractCommand;
use SmoothCode\Propagation\CommandBus;
use SmoothCode\Sample\Domain\Command\ImportExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\Currency;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;
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
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * Create a new command instance.
     *
     * @param CommandBus $commandBus
     */
    public function __construct(CommandBus $commandBus)
    {
        parent::__construct();
        $this->commandBus = $commandBus;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     * @throws \Exception
     */
    public function handle()
    {
        $this->commandBus->dispatch(
            ImportExchangeRate::fromPayload([
                ImportExchangeRate::SOURCE_CURRENCY => Currency::EUR(),
                ImportExchangeRate::TARGET_CURRENCY => Currency::PLN(),
                ImportExchangeRate::RATE => 4.29
            ])
        );
//        $command = new class extends AbstractCommand {
//            protected static array $requiredFields = [
//                'name',
//                'age'
//            ];
//
//            public string $name;
//
//            public int $age;
//        };
//
//        $test = $command::fromPayload(['name' => 'Jan', 'age' => 12]);
//        dump($test);

//        $id = ExchangeRateId::generate();
//
//        $currencyClient = new CurrencyLayerCurrencyAdapter();
//        $rate = $currencyClient->getRate('EUR', 'PLN');
//
//        dump($rate);
//        $exchangeRate = ExchangeRate::create(
//            $id,
//            Currency::EUR(),
//            Currency::PLN(),
//            $rate
//        );
//
////        dump($exchangeRate);
//
//        $this->exchangeRateRepository->save($exchangeRate);
//        /** @var ExchangeRateId $rateId */
//        $rateId = ExchangeRateId::fromString('fd687aa4-183f-11ea-bf7b-588a5a2101d4');
//        dump($this->exchangeRateRepository->find($rateId));

        return 1;
    }
}
