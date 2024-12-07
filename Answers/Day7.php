<?php

namespace Answers;

use Exception;

class Day7 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day7.test';
    protected string $mainFile = 'day7.main';

    protected array $equations = [];

    protected function readFile(): void
    {
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            $row = trim($row);
            if (strlen($row) === 0) {
                continue;
            }
            $data = explode(": ", $row, 2);
            $this->equations[] = [(int) $data[0], $data[1]];
        }
    }

    protected array $operators = ['+' , '*'];

    protected function canBeValidEquation(int $result, string $equation): bool
    {
        $data = explode(" ", $equation);
        $count = count($data);

        for ($i = 0; strlen(base_convert($i, 10, count($this->operators))) < $count; $i++) {
            $operators = str_split(str_pad(base_convert($i, 10, count($this->operators)), $count - 1, '0', STR_PAD_LEFT));

            $testEquation = $this->buildEquation($data, $operators);
            if (eval('return ' . $testEquation . ';') === $result) {
                return true;
            }
        }
        return false;
    }

    protected function buildEquation(array $numbers, array $operators): string
    {
        $result = array_shift($numbers);
        foreach ($numbers as $pos => $number) {
            if ( $this->operators[$operators[$pos]] === '||') {
                $result = $result.$number;
            } else {
                $result = eval('return ' . $result . $this->operators[$operators[$pos]] . $number . ';');
            }
        }

        return $result;
    }

    public function part1(): void
    {
        $sum = 0;
        foreach ($this->equations as $equation) {
            if ($this->canBeValidEquation(...$equation)) {
                $sum += (int) $equation[0];
            }
        }
        echo $sum . PHP_EOL;
    }


    public function part2(): void
    {
        $this->operators[] = '||';
        $this->part1();
    }

}