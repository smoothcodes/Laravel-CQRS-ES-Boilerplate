<?php


namespace CurrencX\Infrastructure\CommandBus;


interface Command
{
    public function getPayload(): array;
}
