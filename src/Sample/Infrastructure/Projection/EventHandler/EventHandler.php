<?php declare(strict_types=1);


namespace SmoothCode\Sample\Infrastructure\Projection\EventHandler;


use Exception;
use Illuminate\Support\Collection;
use SmoothCode\Sample\Infrastructure\Projection\StoredEvent;

interface EventHandler
{
    public function handles(): array;

    public function handle(StoredEvent $event);

    public function handleException(Exception $exception): void;

    public function getEventHandlingMethods(): Collection;
}
