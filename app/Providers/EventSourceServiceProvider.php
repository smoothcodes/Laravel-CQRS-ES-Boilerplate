<?php

namespace App\Providers;

use SmoothCode\Sample\Application\Tutor\Repository\EventSauceTutorRepository;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRateRepository;
use SmoothCode\Sample\Domain\Tutor\TutorRepository;
use SmoothCode\Sample\Infrastructure\EventSourcing\EloquentMessageRepository;
use SmoothCode\Sample\Infrastructure\ExchangeRate\EventSauceExchangeRateRepository;
use EventSauce\EventSourcing\Serialization\ConstructingMessageSerializer;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
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
        $this->app->singleton(TutorRepository::class, EventSauceTutorRepository::class);
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
