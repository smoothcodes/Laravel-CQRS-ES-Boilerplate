<?php

namespace SmoothCode\Sample\Domain\Tutor\Command;

use SmoothCode\Propagation\AbstractCommand;
use SmoothCode\Sample\Domain\Tutor\TechStack;
use SmoothCode\Sample\Shared\ValueObjects\Email;
use SmoothCode\Sample\Shared\ValueObjects\Password;

class CreateTutor extends AbstractCommand
{

    const EMAIL = 'email';
    const PASSWORD = 'password';
    const FIRSTNAME = 'firstname';
    const LASTNAME = 'lastname';
    const EXPERIENCE = 'experience';
    const TECH_STACK = 'techStack';

    protected static array $requiredFields
        = [
            self::EMAIL,
            self::PASSWORD
        ];

    protected static array $allowedFields
        = [
            self::EMAIL,
            self::FIRSTNAME,
            self::PASSWORD,
            self::LASTNAME,
            self::EXPERIENCE,
            self::TECH_STACK
        ];

    private Email $email;
    private Password $password;
    private string $firstname = '';
    private string $lastname = '';
    private float $experience = 0.0;
    private TechStack $techStack;

    /**
     * @return Email
     */
    public function getEmail(): Email
    {
        return $this->email;
    }

    /**
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @return float
     */
    public function getExperience(): float
    {
        return $this->experience;
    }

    /**
     * @return TechStack
     */
    public function getTechStack(): ?TechStack
    {
        return $this->techStack ?? new TechStack();
    }
}
