<?php

namespace SmoothCode\Sample\Infrastructure\EventSourcing;

use EventSauce\EventSourcing\AggregateRootRepository;
use EventSauce\EventSourcing\ClassNameInflector;
use EventSauce\EventSourcing\ConstructingAggregateRootRepository;
use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\DefaultHeadersDecorator;
use EventSauce\EventSourcing\DotSeparatedSnakeCaseInflector;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageDecorator;
use EventSauce\EventSourcing\MessageDecoratorChain;
use EventSauce\EventSourcing\MessageDispatcherChain;
use Illuminate\Container\Container;
use SmoothCode\Sample\Domain\ExchangeRate\ExchangeRate;

final class AggregateRootRepositoryFactory
{
    /**
     * @var EloquentMessageRepository
     */
    private EloquentMessageRepository $eloquentMessageRepository;

    public function __construct(EloquentMessageRepository $eloquentMessageRepository)
    {
        $this->eloquentMessageRepository = $eloquentMessageRepository;
    }

    public function create(array $consumers, array $eventConsumers): AggregateRootRepository
    {
        return new ConstructingAggregateRootRepository(
            ExchangeRate::class,
            $this->eloquentMessageRepository,
            new MessageDispatcherChain(
                new LaravelMessageDispatcher(...$consumers),
                new LaravelEventDispatcher(...$eventConsumers)
            ),
            new MessageDecoratorChain(
                new DefaultHeadersDecorator(),
                new class implements MessageDecorator
                {

                    private string $className;

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
        );
    }
}
