<?php

namespace BadgeBatch;

class SkillMatrix
{
    /**
     * @var SkillRepository
     */
    private $skillRepository;

    /**
     * @param SkillRepository $skillRepository
     */
    public function __construct(SkillRepository $skillRepository)
    {
        $this->skillRepository = $skillRepository;
    }

    /**
     * @return array[]
     */
    public function get()
    {
        $personNames = $this->skillRepository->findPersonNames();

        $self = $this;
        $ret  = [array_merge([''], $personNames)];
        foreach ($this->skillRepository->findSkillNames() as $skillName) {

            $ret[] = array_merge(
                [$skillName],
                array_map(
                    function ($person) use ($self, $skillName) {
                        return $self->skillRepository->findLevelByPersonAndSkillName($person, $skillName);
                    },
                    $personNames
                )
            );
        }

        return $ret;
    }
}
