<?php declare(strict_types = 1);

namespace SmoothCode\Sample\Domain\Tutor;

use SmoothCode\Sample\Shared\ValueObjects\Id;

interface TutorRepository
{
    public function find(Id $tutorId): Tutor;

    public function save(Tutor $tutor): void;
}
