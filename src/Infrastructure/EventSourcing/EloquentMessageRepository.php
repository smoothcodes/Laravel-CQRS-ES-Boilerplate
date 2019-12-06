<?php declare(strict_types=1);

namespace CurrencX\Infrastructure\EventSourcing;


use Doctrine\DBAL\Connection;
use EventSauce\EventSourcing\AggregateRootId;
use EventSauce\EventSourcing\Header;
use EventSauce\EventSourcing\Message;
use EventSauce\EventSourcing\MessageRepository;
use EventSauce\EventSourcing\Serialization\MessageSerializer;
use Generator;
use EventSauce\EventSourcing;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use Webmozart\Assert\Assert;

class EloquentMessageRepository implements MessageRepository
{
    /**
     * @var Connection
     */
    private Connection $connection;

    private string $tableName;

    /**
     * @var MessageSerializer
     */
    private MessageSerializer $serializer;
    /**
     * @var int
     */
    private int $jsonEncodeOption;

    public function __construct(
        MessageSerializer $serializer,
        string $table = 'events',
        int $jsonEncodeOption = 0
    ) {
        $this->tableName        = $table;
        $this->serializer       = $serializer;
        $this->jsonEncodeOption = $jsonEncodeOption;
    }

    public function persist(Message ...$messages)
    {
        if (count($messages) < 1) {
            return;
        }

        $sql    = $this->baseSql($this->tableName);
        $params = [];
        $values = [];

        foreach ($messages as $index => $message) {
            $payload                    = $this->serializer->serializeMessage($message);
            $eventIdColumn              = sprintf('event_id_%s', $index);
            $aggregateRootTypeColumn    = sprintf('aggregate_root_type_%s', $index);
            $aggregateRootIdColumn      = sprintf('aggregate_root_id_%s', $index);
            $aggregateRootIdTypeColumn  = sprintf('aggregate_root_type_id_%s', $index);
            $eventTypeColumn            = sprintf('event_type_%s', $index);
            $aggregateRootVersionColumn = sprintf('aggregate_root_version_%s', $index);
            $timeOfRecordingColumn      = sprintf('created_at_%s', $index);
            $payloadColumn              = sprintf('payload_%s', $index);
            $values[]                   = sprintf(
                '(:%s, :%s, :%s, :%s, :%s, :%s, :%s, :%s)',
                $eventIdColumn,
                $eventTypeColumn,
                $aggregateRootIdColumn,
                $aggregateRootIdTypeColumn,
                $aggregateRootTypeColumn,
                $aggregateRootVersionColumn,
                $timeOfRecordingColumn,
                $payloadColumn
            );

            $params[$aggregateRootVersionColumn] = $payload['headers'][Header::AGGREGATE_ROOT_VERSION];
            $params[$aggregateRootTypeColumn]    = $payload['headers']['__aggregate_root_type'];
            $params[$aggregateRootIdTypeColumn]  = $payload['headers'][Header::AGGREGATE_ROOT_ID_TYPE];
            $params[$timeOfRecordingColumn]      = $payload['headers'][Header::TIME_OF_RECORDING];
            $params[$eventIdColumn]              = $payload['headers'][Header::EVENT_ID] ?? (string)Uuid::uuid1();
            $params[$payloadColumn]              = json_encode($payload, $this->jsonEncodeOption);
            $params[$eventTypeColumn]            = $payload['headers'][Header::EVENT_TYPE] ?? null;
            $params[$aggregateRootIdColumn]      = $payload['headers'][Header::AGGREGATE_ROOT_ID] ?? null;
        }

        $sql .= join(', ', $values);

        DB::transaction(
            function () use ($sql, $params) {
                DB::insert($sql, $params);
            }
        );

    }

    public function retrieveAll(AggregateRootId $id): Generator
    {
        $rows = DB::table($this->tableName)
            ->select('payload')
            ->from($this->tableName)
            ->orderBy('created_at', 'ASC')
            ->get()
            ->map(fn (\stdClass $row) => $this->serializer->unserializePayload(json_decode($row->payload, true)))
            ->toArray();

        foreach ($rows as $row) {
            yield from $row;
        }
    }

    public function retrieveAllAfterVersion(AggregateRootId $id, int $aggregateRootVersion): Generator
    {
        return yield;
        // TODO: Implement retrieveAllAfterVersion() method.
    }

    protected function baseSql($tableName)
    {
        return <<<SQL
               INSERT INTO $tableName (event_id, event_type, aggregate_root_id, aggregate_root_id_type, aggregate_root_type, aggregate_root_version, created_at, payload) VALUES 
               SQL;

    }

}
