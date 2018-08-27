<?php

namespace App\ArrayOperators;

interface ArrayOperationsInterface
{

    public function changePosEls(array &$a, $i, $j): ArrayOperationsInterface;

    /**
     * Indexes start from 0 to (count - 1)
     */
    public function findIndexMinimalEl(array &$arr, $startIndex, $stopIndex): int;
}
