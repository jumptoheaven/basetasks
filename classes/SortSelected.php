<?php
//php 7.0

class SortSelected implements SortableInterface
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
		   $indexMinimalEl = $this->findIndexMinimalEl($a, $startIndex, $stopIndex);

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
		return $a;
	}

    /**
     * Indexes start from 0 to (count - 1)
     */
    private function findIndexMinimalEl(
        array &$arr, $startIndex, $stopIndex
    )
    {
        $res = $startIndex;
        for ($i = $startIndex; $i < $stopIndex; $i++) {
            $i2 = $i + 1;
            if ($arr[$i2] < $arr[$i]) {
                $res = $i2;
            }
        }
        return $res;
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
