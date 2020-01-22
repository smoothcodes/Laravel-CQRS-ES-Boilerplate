<?php declare(strict_types = 1);

namespace SmoothCode\Sample\Infrastructure\Projection\Serializers;

use SmoothCode\Sample\Infrastructure\Projection\ShouldBeStored;
use Symfony\Component\Serializer\SerializerInterface;

class EventSerializer implements SerializerInterface {
    public function serialize($data, $format, array $context = [])
    {
        // TODO: Implement serialize() method.
    }

    public function deserialize($data, $type, $format, array $context = []): ShouldBeStored
    {
        // TODO: Implement deserialize() method.
    }

}
