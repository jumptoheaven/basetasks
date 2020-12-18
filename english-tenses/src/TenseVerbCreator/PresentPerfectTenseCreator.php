<?php

namespace App\TenseVerbCreator;

use App\Defenders\FaceDefender;
use App\Formatter\OutputFormatter;
use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;
use App\WordForms\VerbForm;

class PresentPerfectTenseCreator implements TenseCreatorInterface
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
        $predicate = $this->getPredicatePerfect($words->getSubject());
        $thirdForm = $this->verbForm->getVerbThirdForm($words);
        return $this->outputFormatter->arrayToString([$predicate, $thirdForm,]);
    }

    /**
     * @param string $subject
     * @return string
     */
    private function getPredicatePerfect(string $subject): string
    {
        $predicate = 'have';
        if ($this->faceDefender->isThirdPerson($subject)) {
            $predicate = 'has';
        }
        return $predicate;
    }
}
