<?php
//php 7.0

include ('SortableInterface.php');

pr("Hello, Dcoder! ");
pr("it's a bubble sort!");

class SortBubble implements SortableInterface
{
	public function sort(
		array $a,
		$descendDirect = false
	): array
	{
		$countEls = count($a);
		$countIter = $countEls - 1;
		$rangeEls = $countEls - 1;
		$lastEl = $countEls - 1;
		for (
			$iter = 0;
			$iter < $countIter;
			$iter++
		) {
			//pr('Main iter #'.$iter);
			for ($i = $lastEl;
				$i > $iter;
				$i--
			) {
				$rightEl = $a[$i];
				$leftEl = $a[$i - 1];
				$isAscend = ($leftEl < $rightEl);
				$isChangePos = (
						$descendDirect && $isAscend
					) || (
						(!$descendDirect) && (!$isAscend)
					);
				if ($isChangePos) {
					$this->changePosEls(
							$a, $i, $i -1
						);
				}
			}
		}
		return $a;
	}

	private function changePosEls(
		array &$a, $i, $j
	)
	{
		$o = $a[$i];
		$a[$i] = $a[$j];
		$a[$j] = $o;
		return $this;
	}
}


$sorter = new SortBubble();
testCases($sorter);

function testCases(SortableInterface $sorter)
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


function pr($s)
{
	echo $s . PHP_EOL;
}

