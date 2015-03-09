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

            $ret[ $name ] = $this->skillFileParser->parse($txtFile->getContents());
        }

        return $ret;
    }
}
