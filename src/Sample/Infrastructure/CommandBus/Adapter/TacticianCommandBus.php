<?php declare(strict_types=1);


namespace SmoothCode\Sample\Infrastructure\CommandBus\Adapter;

use SmoothCode\Propagation\Command;
use SmoothCode\Propagation\CommandBus;

class TacticianCommandBus implements CommandBus
{
    private \League\Tactician\CommandBus $commandBus;

    public function __construct(\League\Tactician\CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function dispatch(Command $command): void
    {
        $this->commandBus->handle($command);
    }

}
