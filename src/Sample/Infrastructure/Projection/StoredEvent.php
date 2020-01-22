<?php declare(strict_types=1);


namespace SmoothCode\Sample\Infrastructure\Projection;

use Carbon\Carbon;
use Illuminate\Support\Arr;
use SmoothCode\Sample\Infrastructure\Projection\Serializers\EventSerializer;

class StoredEvent implements Arrayable
{
    public int $id;

    public string $payload;

    public string $aggregateUuid;

    public string $eventClass;

    public array $meta;

    public Carbon $createdAt;

    public ShouldBeStored $event;

    public function __construct(StoredEventData $data)
    {
        $this->id            = $data->getId() ?? null;
        $this->payload       = $data->getPayload();
        $this->aggregateUuid = $data->getAggregateUuid();
        $this->eventClass    = $data->getEventClass();
        $this->meta          = $data->getMeta();
        $this->createdAt     = $data->getCreatedAt();

        try {
            /** @var EventSerializer $eventSerializer */
            $eventSerializer = app(EventSerializer::class);
            $this->event     = $eventSerializer->deserialize(
                $this->payload,
                $this->getActualClassForEvent($this->eventClass),
                'json',
                );
        } catch (\Exception $exception) {

        }
    }

    public function handle(): void
    {

    }

    protected function getActualClassForEvent(string $class): string
    {
        return Arr::get(config('event-projector.event_class_map', []), $class, $class);
    }

    public function toArray(): array
    {
        return [
            'id'            => $this->id,
            'payload'       => $this->payload,
            'aggregateUuid' => $this->aggregateUuid,
            'eventClass'    => $this->eventClass,
            'meta'          => $this->meta,
            'createdAt'     => $this->createdAt
        ];
    }

}
