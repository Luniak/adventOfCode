<?php

namespace Answers;

use Exception;

class Day3 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day3.test';
    protected string $mainFile = 'day3.main';

    protected array $commands = [];
    protected function readFile(): void
    {
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            if (strlen($row) < 1) {
                continue;
            }

            $correct = [];
            preg_match_all(
                '/(mul\([0-9]+,[0-9]+\))|(do(n\'t)?\(\))/m',
                $row,
                $correct
            );
            $this->commands = array_merge($this->commands, $correct[0]);
        }
    }

    protected function calculate(string $operation): bool|int
    {
        $command = substr($operation, 0, strpos($operation, '('));
        $numbers = explode(',', substr($operation, strpos($operation, '(') + 1, -1));

        switch ($command) {
            case 'mul':
                return $this->mul($numbers);
            case 'do':
                return true;
            case 'don\'t':
                return false;
        }

        throw new Exception("Unknown operation $command");
    }

    protected function mul(array $elems): int
    {
        $equals = array_shift($elems);
        foreach ($elems as $number) {
            $equals *= $number;
        }

        return $equals;
    }

    public function part1(): void
    {
        $numbers = [];
        foreach ($this->commands as $command) {
            $result = $this->calculate($command);
            if (!is_bool($result)) {
                $numbers[] = $result;
            }
        }

        echo array_sum($numbers);
    }

    public function part2(): void
    {
        $numbers = [];
        $process = true;

        foreach ($this->commands as $command) {
            $result = $this->calculate($command);
            if (is_bool($result)) {
                $process = $result;
            } elseif($process) {
                $numbers[] = $result;
            }
        }

        echo array_sum($numbers);
    }
}