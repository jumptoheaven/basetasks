<?php

namespace App\SentenceCreator;

use App\Formatter\OutputFormatter;
use App\Model\SentenceWords;
use App\TenseVerbCreator\TenseCreatorInterface;

class SentenceCreator
{

    /**
     * @var OutputFormatter
     */
    private $outputFormatter;

    public function __construct()
    {
        $this->outputFormatter = new OutputFormatter();
    }

    public function create(SentenceWords $words, TenseCreatorInterface $transformer): string
    {
        $words = [
            $words->getSubject(),
            $transformer->transformVerb($words, $this),
            $words->getAddition(),
        ];
        return $this->outputFormatter->upperFirstSymbol(
            $this->outputFormatter->arrayToString($words)
        );
    }
}
