<?php

namespace SmoothCode\Sample\Shared\ValueObjects;

use Illuminate\Support\Facades\Hash;
use Webmozart\Assert\Assert;

class Password {
    protected string $hash;

    public function __construct($plainPassword)
    {
        Assert::minLength($plainPassword, 6);

        $this->hash = Hash::make($plainPassword);
    }

    public function hashedPassword()
    {
        return $this->hash;
    }
}
