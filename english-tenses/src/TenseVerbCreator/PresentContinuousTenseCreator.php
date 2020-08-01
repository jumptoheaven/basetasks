<?php

namespace App\TenseVerbCreator;

use App\Defenders\FaceDefender;
use App\Formatter\OutputFormatter;
use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;

class PresentContinuousTenseCreator implements TenseCreatorInterface
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

    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string
    {
        $predicate = $this->getPredicateContinuous($words->getSubject());
        $gerund = $this->getGerund($words);
        return $this->outputFormatter->arrayToString([$predicate, $gerund,]);
    }

    /**
     * @param string $subject
     * @return string
     */
    private function getPredicateContinuous(string $subject): string
    {
        $predicate = '';
        if ($this->faceDefender->isThirdFace($subject)) {
            $predicate = 'is';
        } elseif ($this->faceDefender->isFirstFace($subject)) {
            $predicate = 'am';
        } else {
            $predicate = 'are';
        }
        return $predicate;
    }

    /**
     * @param SentenceWords $words
     * @return string
     */
    private function getGerund(SentenceWords $words): string
    {
        return $words->getVerb() . 'ing';
    }
}
