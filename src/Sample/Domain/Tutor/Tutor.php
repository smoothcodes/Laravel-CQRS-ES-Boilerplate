<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\Tutor;

use EventSauce\EventSourcing\AggregateRoot;
use EventSauce\EventSourcing\AggregateRootBehaviour;
use SmoothCode\Sample\Domain\Tutor\Event\TutorCreated;
use SmoothCode\Sample\Shared\ValueObjects\Email;
use SmoothCode\Sample\Shared\ValueObjects\Id;
use SmoothCode\Sample\Shared\ValueObjects\Password;

class Tutor implements AggregateRoot
{
    use AggregateRootBehaviour;

    protected Email $email;

    protected Password $passwordHash;

    protected string $firstname;

    protected string $lastname;

    protected float $experience;

    protected TechStack $techStack;

    public static function create(
        Id $id,
        Email $email,
        Password $password,
        string $firstname = null,
        string $lastname = null,
        float $experience = null,
        TechStack $techStack = null
    ) {
        $tutor = new static($id);
        $tutor->recordThat(
            new TutorCreated(
                $id,
                $email,
                $password,
                $firstname,
                $lastname,
                $experience,
                $techStack
            )
        );

        return $tutor;
    }

    protected function applyTutorCreated(TutorCreated $tutorCreated): void
    {
        $this->email        = $tutorCreated->getEmail();
        $this->passwordHash = $tutorCreated->getPassword();
        $this->firstname    = $tutorCreated->getFirstname();
        $this->lastname     = $tutorCreated->getLastname();
        $this->experience   = $tutorCreated->getExperience();
        $this->techStack    = $tutorCreated->getTechStack();
    }
}
