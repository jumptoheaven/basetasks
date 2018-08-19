<?php
//php 7.0

include ('_helper.php');

pr("Hello, Dcoder! ");
pr("it's varios sort!");

$cases = [
    'SortBubble' => [
        'class' => 'SortBubble',
        'description' => 'It is a simple bubble sort',
    ],
];

if (count($argv) < 2) {
    die('Wrong usage: php ' . __FILE__ . ' className' . PHP_EOL);
}

$className = $argv[1];

if (array_key_exists($className, $cases)) {
    $case = $cases[$className];
    pr( 'Run class: ' . $case['class'] );
    pr( 'Description: ' . $case['description'] );
} else {
    die('Unknown class' . PHP_EOlL);
}

$sorter = new $className();
$tester = new TestSortable();
$tester->testCases($sorter);

