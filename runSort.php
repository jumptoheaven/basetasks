<?php
// php 7.0
// iconv -f utf-16le -t utf-8 _helper.php.bk > _helper.php
// file -i *
// sed -i $'1s/^\uFEFF//' _helper.php


include ('_helper.php');

use App\ArrayOperators\ArrayOperations;
use App\Tester\TesterSortable;

pr("Hello, Dcoder! ");
pr("it's varios sort!");

$cases = [
    'BubbleSort' => [
        'class' => '\\App\\Sorter\\BubbleSort',
    ],
    'SelectionSort' => [
        'class' => '\\App\\Sorter\\SelectionSort',
    ],
];

if (count($argv) < 2) {
    die('Wrong usage: php ' . __FILE__ . ' className' . PHP_EOL);
}

$className = $argv[1];

if (array_key_exists($className, $cases)) {
    $case = $cases[$className];
    $classPath = $case['class'];
    pr( 'Run class: ' . $classPath);
} else {
    die('Unknown class' . PHP_EOlL);
}

$arrayOperators = ArrayOperations::createObject();
$sorter = new $classPath($arrayOperators);
pr( 'Description: ' . $sorter-> descriptionAlgorithm() );
$tester = TesterSortable::createObject();
$tester->testCases($sorter)
    ->processResult();
