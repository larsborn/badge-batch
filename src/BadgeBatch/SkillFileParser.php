<?php

namespace BadgeBatch;

use Symfony\Component\Yaml\Parser;
use Symfony\Component\Yaml\Exception\ParseException;

class SkillFileParser
{
    /**
     * @param string $content
     *
     * @return array
     */
    public function parse($content)
    {
        $parser = new Parser();
        $skills = [];

        try {
            $data = $parser->parse($content);
        } catch (ParseException $e) {
            return [];
        }

        foreach ($data as $skill => $rank) {
            if (! is_string($rank)) {
                continue;
            }

            $skills[] = new Skill($skill, $rank);
        }

        return $skills;
    }
}
