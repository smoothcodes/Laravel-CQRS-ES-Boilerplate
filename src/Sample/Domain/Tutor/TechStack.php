<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\Tutor;

use Illuminate\Support\Collection;
use Webmozart\Assert\Assert;

class TechStack
{
    protected Collection $items;

    public function __construct()
    {
        $this->items = new Collection();
    }

    public function add(TutorTechnology $technology)
    {
        $this->items->add($technology);

        return $this;
    }

    public function getItems()
    {
        return $this->items;
    }
}
