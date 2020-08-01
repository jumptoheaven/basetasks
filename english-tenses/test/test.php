<?php

use App\Model\SentenceWords;
use App\TenseVerbCreator\TransformerFactory;
use Test\TestTense;

require __DIR__ . "/../vendor/autoload.php";

echo "**\n";
$debug = (($argv[1] ?? '') === 'debug');
$tester = new TestTense($debug);
$transformerFactory = new TransformerFactory();

$words = new SentenceWords();
$words->setSubject('I');
$words->setVerb('see');
$words->setAddition('TV');
$tester->testTense($transformerFactory->createPresentSimple(), $words, 'I see TV');
$tester->testTense($transformerFactory->createPresentContinuous(), $words, 'I am seeing TV');
$tester->testTense($transformerFactory->createPresentFuture(), $words, 'I will see TV');

$words = new SentenceWords();
$words->setSubject('he');
$words->setVerb('see');
$words->setAddition('TV');
$tester->testTense($transformerFactory->createPresentSimple(), $words, 'He sees TV');
$tester->testTense($transformerFactory->createPresentContinuous(), $words, 'He is seeing TV');
$tester->testTense($transformerFactory->createPresentFuture(), $words, 'He will see TV');

$words = new SentenceWords();
$words->setSubject('They');
$words->setVerb('see');
$words->setAddition('TV');
$tester->testTense($transformerFactory->createPresentSimple(), $words, 'They see TV');
$tester->testTense($transformerFactory->createPresentContinuous(), $words, 'They are seeing TV');
$tester->testTense($transformerFactory->createPresentFuture(), $words, 'They will see TV');
