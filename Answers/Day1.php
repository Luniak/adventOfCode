<?php

namespace Answers;

class Day1 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day1.test';
    protected string $mainFile = 'day1.main';

    protected array $list1 = [];
    protected array $list2 = [];

    protected function readFile(): void
    {
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            if (strlen($row) < 5) {
                continue;
            }

            $t = explode("   ", $row);
            $this->list1[] = (int)$t[0];
            $this->list2[] = (int)$t[1];
        }
    }

    public function part1(): void
    {
        sort($this->list1);
        sort($this->list2);

        $diffs = [];
        foreach ($this->list1 as $id => $elem) {
            $diffs[] = abs($elem - $this->list2[$id]);
        }

        echo array_sum($diffs);
    }

    public function part2(): void
    {
        $similarity = [];
        $list2occur = array_count_values($this->list2);
        foreach ($this->list1 as $elem) {
            $similarity[] = $elem * ($list2occur[$elem] ?? 0);
        }

        echo array_sum($similarity);
    }
}