<?php declare(strict_types=1);

namespace SmoothCode\Sample\Domain\Tutor;

use SmoothCode\Sample\Shared\ValueObjects\Technology;

class TutorTechnology
{
    protected Technology $tech;

    protected KnowledgeLevel $knowledgeLevel;

    /**
     * TutorTechnology constructor.
     * @param Technology $tech
     * @param KnowledgeLevel $knowledgeLevel
     */
    public function __construct(Technology $tech, KnowledgeLevel $knowledgeLevel)
    {
        $this->tech           = $tech;
        $this->knowledgeLevel = $knowledgeLevel;
    }


    /**
     * @return Technology
     */
    public function getTech(): Technology
    {
        return $this->tech;
    }

    /**
     * @return KnowledgeLevel
     */
    public function getKnowledgeLevel(): KnowledgeLevel
    {
        return $this->knowledgeLevel;
    }


}
