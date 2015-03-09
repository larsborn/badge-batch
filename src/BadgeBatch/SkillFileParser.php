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
        foreach (explode("\n", $content) as $line) {
            $line = trim($line);
            if (! $line) {
                continue;
            }

            $exp = array_filter(array_map('trim', explode(':', $line, 2)));
            if (count($exp) != 2) {
                continue;
            }

            $skills[] = new Skill($exp[0], $exp[1]);
        }

        return $skills;
    }
}
