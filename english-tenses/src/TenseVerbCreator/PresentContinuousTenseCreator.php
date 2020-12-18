<?php

namespace App\TenseVerbCreator;

use App\Defenders\FaceDefender;
use App\Formatter\OutputFormatter;
use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;
use App\WordForms\VerbForm;

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
    /**
     * @var VerbForm
     */
    private $verbForm;

    public function __construct()
    {
        $this->faceDefender = new FaceDefender();
        $this->outputFormatter = new OutputFormatter();
        $this->verbForm = new VerbForm();
    }

    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string
    {
        $predicate = $this->getPredicateContinuous($words->getSubject());
        $gerund = $this->verbForm->getIngForm($words);
        return $this->outputFormatter->arrayToString([$predicate, $gerund,]);
    }

    /**
     * @param string $subject
     * @return string
     */
    private function getPredicateContinuous(string $subject): string
    {
        $predicate = '';
        if ($this->faceDefender->isThirdPerson($subject)) {
            $predicate = 'is';
        } elseif ($this->faceDefender->isFirstSingleFace($subject)) {
            $predicate = 'am';
        } else {
            $predicate = 'are';
        }
        return $predicate;
    }
}
