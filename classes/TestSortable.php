<?php
//php 7.0

class TestSortable
{
    public function testCases(SortableInterface $sorter)
    {
	    $cases = [
    		['a'=>[1,2,4,5,7,],
	    		'b'=>[1,2,4,5,7,],],
	    	['a'=>[5,2,1,4,7,],
		    	'b'=>[1,2,4,5,7,],],
    		['a'=>[7,5,4,2,1,],
			    'b'=>[1,2,4,5,7,],],
    	];
    	foreach ($cases as $testCase) {
	    	$testData = $testCase['a'];
    		$answer = $sorter
	        		->sort($testData);
    		$answStr = json_encode($answer);

    		$assert = $testCase['b'];
	    	$assertStr = json_encode($assert);

	    	$r = ($answer == $assert) ?
	    		'SUCCESSES' : 'ERROR';
	    	$msg = $r . ' [answ/assert]: '
	    		. $answStr . ' / '
    			. $assertStr;
		    pr($msg);
	    }
    }
}

