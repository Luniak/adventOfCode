<?php
namespace Core;

class Core
{
    public function __construct(string $mode = 'test', int $day = 1, int $part = 1, ... $params)
    {
        $class = "Answers\Day$day";
        $t = new $class($mode);
        $t->{'part' . $part}();
    }
}