<?php

namespace BadgeBatch;

use Symfony\Component\Yaml\Parser;

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

        // todo might throw Symfony\Component\Yaml\Exception\ParseException
        //      do we want to catch this here or handle further up
        $data = $parser->parse($content);

        foreach ($data as $skill => $rank) {
            // todo check for allowed values
            if (! is_string($rank)) {
                continue;
            }

            $skills[] = new Skill($skill, $rank);
        }

        return $skills;
    }
}
