<?php

namespace Answers;

use Exception;

class Day4 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day4.test';
    protected string $mainFile = 'day4.main';

    protected array $crossword = [];
    protected array $size = [];

    protected function readFile(): void
    {
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            if (strlen($row) < 5) {
                continue;
            }
            $this->crossword[] = str_split(trim($row));
        }
        $this->size = [count($this->crossword[0]), count($this->crossword)];
    }

    public function part1(): void
    {
        $occurrences = 0;
        foreach ($this->crossword as $y => $row) {
            foreach ($row as $x => $letter) {
                if ($letter === 'X') {
                    $occurrences += $this->lookForWord($x, $y);
                }
            }
        }

        echo $occurrences;
    }

    protected array $directions = [
        'r' => [1, 0], //Right
        'rd' => [1, 1], //Right Down
        'd' => [0, 1], //Down
        'ld' => [-1, 1], //Left Down
        'l' => [-1, 0], //Left
        'lu' => [-1, -1], //Left Up
        'u' => [0, -1], //Up
        'ru' => [1, -1], //Right Up
    ];

    protected function lookForWord(int $x, int $y): int
    {
        $found = 0;
        foreach ($this->directions as $coordsChange) {
            if ($this->checkDirection($x, $y, ...$coordsChange)) {
                $found++;
                echo "Found [$x, $y]" . PHP_EOL;
            }
        }

        return $found;
    }

    protected function checkDirection(int $x, int $y, int $xAdd, int $yAdd): bool
    {
        if (
            $y + $yAdd*3 < 0
            || $y + $yAdd*3 >= $this->size[1]
            || $x + $xAdd*3 < 0
            || $x + $xAdd*3 >= $this->size[0]
        ) {
            return false;
        }

        return (
            $this->crossword[$y + $yAdd][$x + $xAdd] === 'M'
            && $this->crossword[$y + $yAdd*2][$x + $xAdd*2] === 'A'
            && $this->crossword[$y + $yAdd*3][$x + $xAdd*3] === 'S'
        );
    }

    public function part2(): void
    {
        $occurrences = 0;
        foreach ($this->crossword as $y => $row) {
            foreach ($row as $x => $letter) {
                if ($letter === 'A') {
                    if ($this->lookForWord2($x, $y)) {
                        $occurrences++;
                        echo "Found [$x, $y]" . PHP_EOL;
                    }
                }
            }
        }

        echo $occurrences;
    }

    protected function checkLetters(int $x, int $y, int $xAddM, int $yAddM, int $xAddS, int $yAddS): bool
    {
        if (
            $x - 1 < 0
            || $x + 1 >= $this->size[0]
            || $y - 1 < 0
            || $y + 1 >= $this->size[1]
        ) {
            return false;
        }

        return (
            $this->crossword[$y + $yAddM][$x + $xAddM] === 'M'
            && $this->crossword[$y + $yAddS][$x + $xAddS] === 'S'
        );
    }

    protected function lookForWord2(int $x, int $y): bool
    {
        return (
                $this->checkLetters($x, $y, ...$this->directions['lu'], ...$this->directions['rd'])
                || $this->checkLetters($x, $y, ...$this->directions['rd'], ...$this->directions['lu'])
            )
            && (
                $this->checkLetters($x, $y, ...$this->directions['ru'], ...$this->directions['ld'])
                || $this->checkLetters($x, $y, ...$this->directions['ld'], ...$this->directions['ru'])
            );
    }

}