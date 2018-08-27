<?php

namespace App\ArrayOperators;

class ArrayOperations implements ArrayOperationsInterface
{

    public static function createObject(): ArrayOperationsInterface
    {
        $obj = new static();
        return $obj;
    }

    public function changePosEls(array &$a, $i, $j): ArrayOperationsInterface
    {
        $o = $a[$i];
        $a[$i] = $a[$j];
        $a[$j] = $o;
        return $this;
    }

    /**
     * Indexes start from 0 to (count - 1)
     */
    public function findIndexMaximumEl(array &$arr, $startIndex, $stopIndex): int
    {
        $res = $startIndex;
        for ($i = $startIndex; $i < $stopIndex; $i++) {
            $i2 = $i + 1;
            if ($arr[$i2] > $arr[$res]) {
                $res = $i2;
            }
        }
        return $res;
    }

    /**
     * Indexes start from 0 to (count - 1)
     */
    public function findIndexMinimalEl(array &$arr, $startIndex, $stopIndex): int
    {
        $res = $startIndex;
        for ($i = $startIndex; $i < $stopIndex; $i++) {
            $i2 = $i + 1;
            if ($arr[$i2] < $arr[$res]) {
                $res = $i2;
            }
        }
        return $res;
    }
}
