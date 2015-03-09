<?php

namespace BadgeBatch;

class SkillFileParser
{
    /**
     * @param string $content
     *
     * @return array
     */
    public function parse($content)
    {
        $skills = [];
        foreach (explode('\n', $content) as $line) {
            $exp = explode(':', $line, 2);

            $skills[] = new Skill($exp[0], $exp[1]);
        }

        return $skills;
    }
}
