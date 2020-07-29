<?php

namespace App\Sorter;

interface SortableInterface
{

    public function descriptionAlgorithm(): string;

    public function nameAlgorithm(): string;

    public function sort(array &$a, $descendDirect = false): SortableInterface;

}
