<?php

namespace App\Transformer;

use App\SentenceCreator;
use App\Model\SentenceWords;

interface TransformerInterface
{

    public function transformVerb(SentenceWords $words, SentenceCreator $activeSpeech): string;
}
