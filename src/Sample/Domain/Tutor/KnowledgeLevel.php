<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\Tutor;

use MyCLabs\Enum\Enum;

/**
 * Class KnowledgeLevel
 * @package SmoothCode\Sample\Domain\Tutor
 *
 * @method static self NOVICE()
 * @method static self BEGINNER()
 * @method static self PREINTERMEDIATE()
 * @method static self INTERMEDIATE()
 * @method static self UPPERINTERMEDIATE()
 * @method static self EXPERT()
 */
class KnowledgeLevel extends Enum
{
    const NOVICE = 0;
    const BEGINNER = 1;
    const PREINTERMEDIATE = 2;
    const INTERMEDIATE = 3;
    const UPPERINTERMEDIATE = 4;
    const EXPERT = 5;
}
