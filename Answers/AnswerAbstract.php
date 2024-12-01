<?php
namespace Answers;

use Exception;
use Generator;

abstract class AnswerAbstract
{
    protected string $mode = 'test';

    public function __construct(string $mode = 'test')
    {
        $this->mode = $mode;
        $this->readFile();
    }
    protected function fileReader(string $fileName): Generator
    {
        $filePath = __DIR__ . DIRECTORY_SEPERATOR . 'Files' . DIRECTORY_SEPERATOR . $fileName;
        if (!file_exists($filePath)) {
            throw new Exception("File $fileName not found!");
        }
        $fh = fopen($filePath, 'r');
        while ($row = fgets($fh)) {
            yield $row;
        }
    }

    protected abstract function readFile(): void;
}