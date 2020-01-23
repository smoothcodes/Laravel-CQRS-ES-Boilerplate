<?php declare(strict_types=1);

namespace SmoothCode\Sample\Application\Tutor\Repository;

use EventSauce\EventSourcing\AggregateRootRepository;
use SmoothCode\Sample\Domain\ExchangeRate\Policy\TutorProjection;
use SmoothCode\Sample\Domain\Tutor\Tutor;
use SmoothCode\Sample\Domain\Tutor\TutorRepository;
use SmoothCode\Sample\Infrastructure\EventSourcing\AggregateRootRepositoryFactory;
use SmoothCode\Sample\Shared\ValueObjects\Id;

class EventSauceTutorRepository implements TutorRepository
{
    protected array $consumers = [
        TutorProjection::class
    ];

    protected array $eventConsumers = [];

    private AggregateRootRepositoryFactory $aggregateRootRepositoryFactory;

    public function __construct(AggregateRootRepositoryFactory $aggregateRootRepositoryFactory)
    {
        $this->aggregateRootRepositoryFactory = $aggregateRootRepositoryFactory;
    }

    public function find(Id $tutorId): Tutor
    {
        /** @var Tutor $tutor */
        $tutor = $this->aggregateRootRepository()->retrieve($tutorId);

        return $tutor;
    }

    public function save(Tutor $tutor): void
    {
        $this->aggregateRootRepository()->persist($tutor);
    }

    private function aggregateRootRepository(): AggregateRootRepository
    {
        return  $this->aggregateRootRepositoryFactory->create($this->consumers, $this->eventConsumers);
    }

}
