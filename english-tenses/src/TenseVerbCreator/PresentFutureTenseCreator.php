<?php

namespace App\TenseVerbCreator;

use App\Defenders\FaceDefender;
use App\Formatter\OutputFormatter;
use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;

class PresentFutureTenseCreator implements TenseCreatorInterface
{

    /**
     * @var FaceDefender
     */
    private $faceDefender;
    /**
     * @var OutputFormatter
     */
    private $outputFormatter;

    public function __construct()
    {
        $this->faceDefender = new FaceDefender();
        $this->outputFormatter = new OutputFormatter();
    }

    /**
     * @param SentenceWords $words
     * @param SentenceCreator $activeSpeech
     * @return string
     */
    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string
    {
        $predicate = 'will';
        $verb = $words->getVerb();
        return $this->outputFormatter->arrayToString([$predicate, $verb,]);
    }
}
