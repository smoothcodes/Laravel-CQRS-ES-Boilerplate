<?php declare(strict_types=1);


namespace CurrencX\Infrastructure\CommandBus\Adapter;

use CurrencX\Infrastructure\CommandBus\Command;
use CurrencX\Infrastructure\CommandBus\CommandBus;

class TacticianCommandBus implements CommandBus
{
    public function dispatch(Command $command): void
    {
//        $command $command::fromPayload()
    }

}
