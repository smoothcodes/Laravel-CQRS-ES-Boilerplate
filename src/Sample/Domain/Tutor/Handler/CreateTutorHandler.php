<?php declare(strict_types=1);


namespace SmoothCode\Sample\Domain\Tutor\Handler;


use SmoothCode\Sample\Domain\Tutor\Command\CreateTutor;
use SmoothCode\Sample\Domain\Tutor\Tutor;
use SmoothCode\Sample\Domain\Tutor\TutorId;
use SmoothCode\Sample\Domain\Tutor\TutorRepository;

class CreateTutorHandler
{
    private TutorRepository $tutorRepository;

    public function __construct(TutorRepository $tutorRepository)
    {
        $this->tutorRepository = $tutorRepository;
    }

    public function __invoke(CreateTutor $command): void
    {
        $tutor = Tutor::create(
            TutorId::generate(),
            $command->getEmail(),
            $command->getPassword(),
            $command->getFirstname(),
            $command->getLastname(),
            $command->getExperience(),
            $command->getTechStack()
        );

        $this->tutorRepository->save($tutor);
    }
}
