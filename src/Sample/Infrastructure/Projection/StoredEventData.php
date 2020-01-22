<?php declare(strict_types = 1);

namespace SmoothCode\Sample\Infrastructure\Projection;

use Carbon\Carbon;

interface StoredEventData {

    public function getId(): int;

    public function getPayload(): string;

    public function getAggregateUuid(): string;

    public function getEventClass(): string;

    public function getMeta(): array;

    public function getCreatedAt(): Carbon;
}
