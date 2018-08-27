<?php
//php 7.0

namespace App\Sorter;

use App\ArrayOperators\ArrayOperationsInterface;

class SelectionSort implements SortableInterface
{

    /** @var ArrayOperationsInterface */
    private $arrayOperations;

    public function __construct(ArrayOperationsInterface $arrayOperations)
    {
        $this->arrayOperations = $arrayOperations;
    }

    public function descriptionAlgorithm(): string
    {
        return 'It is a simple selection sort';
    }

    public function nameAlgorithm(): string
    {
        return 'Selection Sort';
    }

    public function sort(array &$a, $descendDirect = false): SortableInterface
    {
        $countEls = count($a);
        $countIter = $countEls - 1;
        $startIndex = 0;
        $stopIndex = $countEls - 1;
        for (
            $iter = 0;
            $iter < $countIter;
            $iter++
        ) {
            // pr('Main iter #'.$iter.' ['.$startIndex.'-'. $stopIndex.']  -|-->  '.json_encode($a));

            $indexMinimalEl = $this->arrayOperations->findIndexMinimalEl($a, $startIndex, $stopIndex);

            $isChangePos = ($indexMinimalEl !== $startIndex);
            if ($isChangePos) {
                $this->arrayOperations->changePosEls($a, $startIndex, $indexMinimalEl);
            }

            // pr('   ['.$startIndex.'-'. $stopIndex.'] -- ' . json_encode([$isChangePos, $startIndex, $indexMinimalEl]) . ' -|-->  ' . json_encode($a)   );

            $startIndex ++;
        }
        return $this;
    }
}
