<?php

namespace Test;

use App\Model\SentenceWords;
use App\SentenceCreator;
use App\Transformer\TransformerInterface;

class TestTense
{

    public function testTense(TransformerInterface $transformer, SentenceWords $words, string $expected): void
    {
        $creator = new SentenceCreator();
        $actual = $creator->create($words, $transformer);
        echo "Expected: $expected\n";
        echo "Actual: $actual\n";
        $result = $actual === $expected;
        echo "Result: $result\n";
    }

}
