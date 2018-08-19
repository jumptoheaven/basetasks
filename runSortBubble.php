<?php
//php 7.0

include ('_helper.php');

pr("Hello, Dcoder! ");
pr("it's a bubble sort!");


$sorter = new SortBubble();
$tester = new TestSortable();
$tester->testCases($sorter);

