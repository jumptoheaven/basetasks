<?php

namespace Test;

use App\Model\SentenceWords;
use App\SentenceCreator;
use App\Transformer\TransformerInterface;

class TestTense
{

    /**
     * @var bool
     */
    private $debug;

    public function __construct(bool $debug)
    {
        $this->debug = $debug;
    }

    public function testTense(TransformerInterface $transformer, SentenceWords $words, string $expected): void
    {
        $creator = new SentenceCreator();
        $actual = $creator->create($words, $transformer);
        $result = $actual === $expected;
        echo $this->resultOut($result) . " - Test: $expected\n";
        if ($this->debug) {
            $countRepeat = strlen($this->resultOut($result)) + 3;
            echo str_repeat(" ", $countRepeat) . "Actual: $actual\n";
        }
    }

    /**
     * @param bool $result
     * @return string
     */
    private function resultOut(bool $result): string
    {
        return $result ? 'OK' : 'FAILED';
    }
}
