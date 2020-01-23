<?php declare(strict_types=1);

namespace SmoothCode\Sample\Shared\ValueObjects;

use Webmozart\Assert\Assert;

class Email
{
    protected string $value;

    public function __construct($emailAddress)
    {
        Assert::email($emailAddress);
        $this->value = $emailAddress;
    }

    /**
     * @return string
     */
    public function getValue(): string
    {
        return $this->value;
    }
}
