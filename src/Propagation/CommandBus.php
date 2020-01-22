<?php


namespace SmoothCode\Propagation;


interface CommandBus
{
    public function dispatch(Command $command): void;
}
