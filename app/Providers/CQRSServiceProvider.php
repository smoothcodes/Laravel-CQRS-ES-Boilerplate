<?php

namespace App\Providers;

use CurrencX\Domain\ExchangeRate\ExchangeRate;
use CurrencX\Domain\ExchangeRate\ExchangeRateRepository;
use CurrencX\Infrastructure\EventSourcing\EloquentMessageRepository;
use CurrencX\Infrastructure\ExchangeRate\EventSauceExchangeRateRepository;
use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\DotSeparatedSnakeCaseInflector;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Illuminate\Container\Container;
use Illuminate\Support\ServiceProvider;

class CQRSServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(EloquentMessageRepository::class)
                  ->needs('$table')
                  ->give('public.events');

        $this->app->bind(MessageSerializer::class, ConstructingMessageSerializer::class);
        $this->app->singleton(ExchangeRateRepository::class, EventSauceExchangeRateRepository::class);
        $this->app
            ->when(EventSauceExchangeRateRepository::class)
            ->needs(AggregateRootRepository::class)
            ->give(
                fn (Container $container) => (new ConstructingAggregateRootRepository(
                    ExchangeRate::class,
                    $container->make(EloquentMessageRepository::class),
                    null,
                    new MessageDecoratorChain(
                        new DefaultHeadersDecorator(),
                        new class implements MessageDecorator
                        {

                            private $className;

                            public function __construct(ClassNameInflector $classNameInflector = null)
                            {
                                $this->className = $classNameInflector ?: (new DotSeparatedSnakeCaseInflector())
                                    ->classNameToType(ExchangeRate::class);
                            }


                            public function decorate(Message $message): Message
                            {

                                return $message->withHeaders(
                                    [
                                        '__aggregate_root_type' => $this->className
                                    ]);
                            }

                        }
                    )
                ))
            );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
