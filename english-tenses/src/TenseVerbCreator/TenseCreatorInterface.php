<?php

namespace App\TenseVerbCreator;

use App\Model\SentenceWords;
use App\SentenceCreator\SentenceCreator;

interface TenseCreatorInterface
{

    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string;
}
