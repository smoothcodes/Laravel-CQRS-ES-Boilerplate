<?php

namespace SmoothCode\Sample\Infrastructure\EventSourcing;

use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Message;

interface EventConsumer {
    public function handle($event, AggregateRootId $aggregateRootId, Message $message);
}
