<?php

namespace App\Transformer;

use App\SentenceCreator;
use App\Defenders\FaceDefender;
use App\Model\SentenceWords;

class PresentSimpleTransformer implements TransformerInterface
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
