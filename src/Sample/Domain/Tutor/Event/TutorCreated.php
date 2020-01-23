<?php declare(strict_types=1);


namespace SmoothCode\Sample\Domain\Tutor\Event;


use EventSauce\EventSourcing\Serialization\SerializablePayload;
use Illuminate\Support\Collection;
use SmoothCode\Sample\Domain\Tutor\TechStack;
use SmoothCode\Sample\Domain\Tutor\TutorId;
use SmoothCode\Sample\Domain\Tutor\TutorTechnology;
use SmoothCode\Sample\Shared\ValueObjects\Email;
use SmoothCode\Sample\Shared\ValueObjects\Id;
use SmoothCode\Sample\Shared\ValueObjects\Password;

class TutorCreated implements SerializablePayload
{
    /**
     * @var Email
     */
    private Email $email;
    /**
     * @var Password
     */
    private Password $password;
    /**
     * @var string|null
     */
    private string $firstname;
    /**
     * @var Id
     */
    private Id $id;
    /**
     * @var string|null
     */
    private string $lastname;
    /**
     * @var float|null
     */
    private float $experience;
    /**
     * @var TechStack|null
     */
    private TechStack $techStack;

    /**
     * TutorCreated constructor.
     * @param TutorId $id
     * @param Email $email
     * @param Password $password
     * @param string|null $firstname
     * @param string|null $lastname
     * @param float|null $experience
     * @param TechStack|null $techStack
     */
    public function __construct(
        TutorId $id,
        Email $email,
        Password $password,
        string $firstname = null,
        string $lastname = null,
        float $experience = null,
        TechStack $techStack = null
    ) {
        $this->id         = $id;
        $this->email      = $email;
        $this->password   = $password;
        $this->firstname  = $firstname;
        $this->lastname   = $lastname;
        $this->experience = $experience;
        $this->techStack  = $techStack;
    }

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
     * @return string|null
     */
    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    /**
     * @return Id
     */
    public function getId(): TutorId
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    /**
     * @return float|null
     */
    public function getExperience(): ?float
    {
        return $this->experience;
    }

    /**
     * @return TechStack|null
     */
    public function getTechStack(): ?TechStack
    {
        return $this->techStack;
    }

    public function toPayload(): array
    {
        return [
            'email'      => $this->email->getValue(),
            'password'   => $this->password->hashedPassword(),
            'firstname'  => $this->firstname,
            'lastname'   => $this->lastname,
            'experience' => $this->experience,
            'techStack'  => $this->techStack->getItems()->map(
                fn (TutorTechnology $tech) => [
                    'technology'     => ['name' => $tech->getTech()],
                    'knowledgeLevel' => (int)$tech->getKnowledgeLevel()
                ])
        ];
    }

    /**
     * @param array $payload
     * @return SerializablePayload
     * @throws \Exception
     */
    public static function fromPayload(array $payload): SerializablePayload
    {
        return new self(
            Id::generate(),
            new Email($payload['email']),
            new Password($payload['password']),
            $payload['firstname'],
            $payload['lastname'],
            $payload['experience'],
            $payload['techStack']
        );
    }


}
