<?php
//php 7.0

namespace App\Sorter;

use App\ArrayOperators\ArrayOperationsInterface;

class BubbleSort implements SortableInterface
{

    /** @var ArrayOperationsInterface */
    private $arrayOperations;

    public function __construct(ArrayOperationsInterface $arrayOperations)
    {
        $this->arrayOperations = $arrayOperations;
    }

    public function descriptionAlgorithm(): string
    {
        return 'It is a simple bubble sort';
    }

    public function nameAlgorithm(): string
    {
        return 'Bubble Sort';
    }

    public function sort(array &$a, $descendDirect = false): SortableInterface
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
					$this->arrayOperations->changePosEls($a, $i, $i -1);
				}
			}
		}
		return $this;
	}
}
