<?php
//php 7.0

class TestSortable
{
     public function testCases(SortableInterface $sorter)
    {
        $cases = [
            ['a'=>[1,2,4,5,7,], 'b'=>[1,2,4,5,7,],],
            ['a'=>[5,2,1,4,7,], 'b'=>[1,2,4,5,7,],],
            ['a'=>[7,5,4,2,1,], 'b'=>[1,2,4,5,7,],],
            ['a'=>[7,97,4,3,0,], 'b'=>[0,3,4,7,97,],],
        ];
        foreach ($cases as $testCase) {
            $testData = $testCase['a'];
            $answer = $sorter->sort($testData);
            $assert = $testCase['b'];

            $r = ($answer == $assert) ? 'OK' : 'ERR';
            $msg = $r . '  [in/res/ass]: '
                . json_encode($testData) . ' / '
                . json_encode($answer) . ' / '
                . json_encode($assert);
            pr($msg);
        }
    }
}
