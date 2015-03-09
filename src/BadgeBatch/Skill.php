<?php

namespace BadgeBatch;

class Skill
{
    public $name;
    public $level;

    /**
     * @param string $name
     * @param string $level
     */
    public function __construct($name, $level)
    {
        $this->name  = $name;
        $this->level = $level;
    }
}
