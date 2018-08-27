<?php

namespace App\Tester;

use App\Sorter\SortableInterface;

interface TesterInterface
{

    public function processResult(): TesterInterface;

     public function testCases(SortableInterface $sorter): TesterInterface;
}
