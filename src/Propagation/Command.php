<?php


namespace SmoothCode\Propagation;


interface Command
{
    public function toPayload(): array;

    public static function fromPayload(array $payload): self;
}
