<?php

namespace App;

use App\Model\SentenceWords;
use App\Transformer\TransformerInterface;

class SentenceCreator
{

    public function __construct()
    {
    }

    public function create(SentenceWords $words, TransformerInterface $transformer): string
    {
        $words = [
            $words->getSubject(),
            $transformer->transformVerb($words, $this),
            $words->getAddition(),
        ];
        return ucfirst(join(' ', $words));
    }

}