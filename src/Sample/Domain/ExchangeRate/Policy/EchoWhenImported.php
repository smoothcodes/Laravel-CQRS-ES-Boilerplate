<?php

namespace SmoothCode\Sample\Domain\ExchangeRate;

use EventSauce\EventSourcing\Consumer;
use EventSauce\EventSourcing\Message;

class EchoWhenImported implements Consumer {
    public function handle(Message $message)
    {
        dump($message);
    }

}
