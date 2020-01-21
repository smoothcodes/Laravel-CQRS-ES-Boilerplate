<?php


namespace CurrencX\Infrastructure\CommandBus;


interface CommandBus
{
    public function dispatch(Command $command): void;
}
