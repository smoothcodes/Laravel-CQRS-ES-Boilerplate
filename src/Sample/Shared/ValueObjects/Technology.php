<?php declare(strict_types=1);

namespace SmoothCode\Sample\Shared\ValueObjects;

class Technology
{
    protected string $name;

    /**
     * Technology constructor.
     * @param string $name
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }


    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }
}
