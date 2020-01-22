<?php declare(strict_types = 1);


namespace SmoothCode\Sample\Infrastructure\Projection;


use SmoothCode\Sample\Infrastructure\Projection\EventHandler\EventHandler;

interface Projector extends EventHandler
{
    public function getName(): string;

    public function shouldBeCalledImmediately(): bool;
}
