<?php

namespace App\Transformer;

use App\SentenceCreator;
use App\Defenders\FaceDefender;
use App\Model\SentenceWords;

class PresentContinuousTransformer implements TransformerInterface
{

    /**
     * @var FaceDefender
     */
    private $faceDefender;

    public function __construct()
    {
        $this->faceDefender = new FaceDefender();
    }

    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string
    {
        $predicate = $this->getPredicateContinuous($words->getSubject());
        $gerund = $this->getGerund($words);
        return $predicate . ' ' . $gerund;
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
