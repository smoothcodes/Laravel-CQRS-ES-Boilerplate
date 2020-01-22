<?php

namespace App\Providers;

use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRate;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;
use SmoothCode\Sample\Infrastructure\EventSourcing\AggregateRootRepositoryFactory;
use SmoothCode\Sample\Infrastructure\EventSourcing\EloquentMessageRepository;
use SmoothCode\Sample\Infrastructure\ExchangeRate\EventSauceExchangeRateRepository;
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

class EventSourceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //@TODO: Split it into separated ServiceProviders. ServiceProvider per Repository
        $this->app->when(EloquentMessageRepository::class)
                  ->needs('$table')
                  ->give('public.events');

        $this->app->bind(MessageSerializer::class, ConstructingMessageSerializer::class);
        $this->app->singleton(ExchangeRateRepository::class, EventSauceExchangeRateRepository::class);
//        $this->app
//            ->when(EloquentMessageRepository::class)
//            ->needs(AggregateRootRepositoryFactory::class)
//            ->give(
//                fn (Container $container) => $container->make(AggregateRootRepositoryFactory::class)->create()
//            );
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
