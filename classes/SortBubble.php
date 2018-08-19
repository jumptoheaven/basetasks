<?php
//php 7.0

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
