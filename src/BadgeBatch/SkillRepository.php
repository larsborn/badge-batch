<?php

namespace BadgeBatch;

use Symfony\Component\Finder\Finder;
use Symfony\Component\Finder\SplFileInfo;

class SkillRepository
{
    /**
     * @var string
     */
    private $folder;

    /**
     * @var SkillFileParser
     */
    private $skillFileParser;

    /**
     * @param string $folder
     * @param SkillFileParser $skillFileParser
     */
    public function __construct($folder, SkillFileParser $skillFileParser)
    {
        $this->folder          = $folder;
        $this->skillFileParser = $skillFileParser;
    }

    /**
     * @return string[]
     */
    public function findPersonNames()
    {
        $personNames = array_keys($this->findAll());
        sort($personNames);

        return $personNames;
    }


    /**
     * @return string[]
     *
     * warning: this code is write-only
     */
    public function findSkillNames()
    {
        $skillNames = array_unique(
            array_map(
                function (Skill $skill) {
                    return $skill->name;
                },
                array_reduce(
                    $this->findAll(),
                    function ($carry, $item) {
                        return array_merge($carry, $item);
                    },
                    []
                )
            )
        );
        sort($skillNames);

        return $skillNames;
    }

    /**
     * @param $person
     * @param $skillName
     *
     * @return string
     */
    public function findLevelByPersonAndSkillName($person, $skillName)
    {
        /** @var Skill[] $skills */
        $skills = $this->findAll()[$person];
        foreach ($skills as $skill) {
            if ($skill->name === $skillName) {
                return $skill->level;
            }
        }

        return '';
    }

    /**
     * @return array
     */
    public function findAll()
    {
        $finder = new Finder();
        $files  = $finder
            ->ignoreUnreadableDirs()
            ->ignoreDotFiles(true)
            ->in($this->folder)
            ->files()
            ->followLinks()
            ->name('*.txt');

        $ret = [];
        /** @var SplFileInfo $txtFile */
        foreach ($files as $txtFile) {
            $name = explode('.', $txtFile->getFilename(), 2)[0];

            $ret[$name] = $this->skillFileParser->parse($txtFile->getContents());
        }

        return $ret;
    }
}
