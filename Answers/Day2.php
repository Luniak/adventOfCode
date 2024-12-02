<?php

namespace Answers;

class Day2 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day2.test';
    protected string $mainFile = 'day2.main';

    protected array $list = [];
    protected function readFile(): void
    {
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            if (strlen($row) < 5) {
                continue;
            }

            $this->list[] = explode(" ", $row);
        }
    }

    protected function isCorrect(int $current, int $next, bool $decreasing): bool
    {
        return
            abs($current-$next) <= 3
            && ($decreasing ? ($current > $next) : ($current < $next));
    }

    public function isSafe(array $row): bool
    {
        $decreasing = $row[0] > $row[1];
        for ($i=0; $i < count($row) -1; $i++) {
            if (!$this->isCorrect($row[$i], $row[$i+1], $decreasing)) {
                return false;
            }
        }
        return true;
    }

    public function isSafeWithDampener(array $row): bool
    {
        for ($i=0; $i < count($row); $i++) {
            $newRow = $row;
            unset($newRow[$i]);
            if ($this->isSafe(array_values($newRow))) {
                return true;
            }
        }
        return false;
    }

    public function part1(): void
    {
        $safe = 0;

        foreach ($this->list as $row) {
            if ($this->isSafe($row)) {
                $safe++;
            }
        }

        echo $safe;
    }

    public function part2(): void
    {
        $safe = 0;
        foreach ($this->list as $row) {
            if ($this->isSafe($row) || $this->isSafeWithDampener($row)) {
                $safe++;
            }
        }

        echo $safe;
    }
}