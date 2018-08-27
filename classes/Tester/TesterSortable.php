<?php

namespace App\Tester;

use App\Sorter\SortableInterface;

class TesterSortable implements TesterInterface
{

    private $countErrors;

    public function __construct()
    {
        $this->countErrors = 0;
    }

    public static function createObject(): TesterInterface
    {
        $obj = new static();
        return $obj;
    }

    public function processResult(): TesterInterface
    {
        $msg = 'Test Result:';
        if ($this->countErrors) {
            $msg .= ' with ERRORS! Count errors: ' . $this->countErrors;
        } else {
            $msg .= ' SUCCESS. It\'s all Ok!';
        }
        $this->printStr($msg);
        return $this;
    }

     public function testCases(SortableInterface $sorter): TesterInterface
    {
        $cases = [
            [1,2,4,5,7,],
            [5,2,1,4,7,],
            [7,5,4,2,1,],
            [7,97,4,3,0,],
            [7,97,4,107,3,0,45,],
        ];
        foreach ($cases as $testData) {
            $answer = $testData;
            $assert = $testData;
            $sorter->sort($answer, false);
            sort($assert);
            $this->processCase($testData, $answer, $assert);

            $answer = $testData;
            $assert = $testData;
            $sorter->sort($answer, true);
            rsort($assert);
            $this->processCase($testData, $answer, $assert);
        }
        return $this;
    }

    private function processCase(array $testData, array $answer, array $assert): TesterInterface
    {
        $isSuccess = ($answer == $assert);
        if (false === $isSuccess) {
            $this->countErrors++;
        }

        $r = ($isSuccess) ? 'OK' : 'ERR';
        $msg = $r . '  [in/res/ass]: ' . json_encode($testData) . ' / ' . json_encode($answer) . ' / ' . json_encode($assert);
        $this->printStr($msg);
        return $this;
    }

    private function printStr($str): TesterInterface
    {
        echo $str . PHP_EOL;
        return $this;
    }
}
