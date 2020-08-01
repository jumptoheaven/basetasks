<?php

namespace App\TenseVerbCreator;

use App\Defenders\FaceDefender;
use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;

class PresentSimpleTenseCreator implements TenseCreatorInterface
{

    /**
     * @var FaceDefender
     */
    private $faceDefender;

    public function __construct()
    {
        $this->faceDefender = new FaceDefender();
    }

    /**
     * @param SentenceWords $words
     * @param SentenceCreator $activeSpeech
     * @return string
     */
    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string
    {
        $verb = $words->getVerb();
        if ($this->faceDefender->isThirdFace($words->getSubject())) {
            $verb .= 's';
        }
        return $verb;
    }
}
