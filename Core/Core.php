<?php
namespace Core;

class Core
{
    public function __construct(string $mode = 'help', int $day = 1, int $part = 1, ... $params)
    {
        if ('help' === $mode) {
            echo
                "Help:\n\r"
                . "Params in order:\n\r"
                . "mode: test/main\n\r"
                . "day: 1-24\n\r"
                . "part: 1-2\n\r"
            ;

        } else {
            $class = "Answers\Day$day";
            $t = new $class($mode);
            $t->{'part' . $part}();
        }
    }
}