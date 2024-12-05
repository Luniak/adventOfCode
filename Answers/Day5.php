<?php

namespace Answers;

use Exception;

class Day5 extends AnswerAbstract implements AnswerInterface
{
    protected string $testFile = 'day5.test';
    protected string $mainFile = 'day5.main';

    protected array $printRules = [];
    protected array $updates = [];

    protected function readFile(): void
    {
        $updates = false;
        foreach ($this->fileReader($this->{$this->mode . 'File'}) as $row) {
            $row = trim($row);
            if (strlen($row) === 0) {
                $updates = true;
                continue;
            }

            if ($updates) {
                $this->updates[] = explode(',', $row);
            } else {
                $rule = explode('|', $row);
                if (!isset($this->printRules[$rule[0]])) {
                    $this->printRules[$rule[0]] = [];
                }
                $this->printRules[$rule[0]][$rule[1]] = 1;
            }
        }
    }


    protected function validatePageRules(int $page, array $after): bool
    {
        foreach ($after as $elem) {
            if (
                !isset($this->printRules[$page][$elem])
                || isset($this->printRules[$elem][$page])
            ) {
                return false;
            }
        }
        return true;
    }

    protected function isValidUpdate(array $update): bool
    {
        foreach ($update as $position => $page) {
            if (!$this->validatePageRules($page, array_slice($update, $position + 1))) {
                return false;
            }
        }
        return true;
    }
    protected function getMiddlePageNumber(array $update): int
    {
        return $update[floor(count($update) / 2)];
    }
    public function part1(): void
    {
        $sum = 0;
        foreach ($this->updates as $update) {
            if ($this->isValidUpdate($update)) {
                echo "Update [" . join(",", $update) . "] is valid!" . PHP_EOL;
                $sum += $this->getMiddlePageNumber($update);
            }
        }
        echo $sum;
    }

    protected function fixUpdate(array $update): array
    {
        $fixed = [];

        foreach ($update as $page) {
            $putAt = 0;
            foreach ($fixed as $toCheck) {
                if (isset($this->printRules[$toCheck][$page])) {
                    $putAt++;
                    continue;
                }
                break;
            }

            if ($putAt === 0) {
                array_unshift($fixed, $page);
            } elseif ($putAt === count($fixed)) {
                $fixed[] = $page;
            } else {
                $before = array_slice($fixed, 0, $putAt);
                $after = array_slice($fixed, $putAt);
                $fixed = array_merge($before, [$page], $after);
            }
        }
        return  $fixed;
    }

    public function part2(): void
    {
        $sum = 0;
        foreach ($this->updates as $update) {
            if (!$this->isValidUpdate($update)) {
                $fixed = $this->fixUpdate($update);
                echo "Update [" . join(",", $update) . "] is fixed as [" . join(",", $fixed) . "]!" . PHP_EOL;
                $sum += $this->getMiddlePageNumber($fixed);
            }
        }
        echo $sum;
    }

}