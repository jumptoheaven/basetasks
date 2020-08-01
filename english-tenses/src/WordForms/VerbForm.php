<?php

namespace App\WordForms;

use App\Model\SentenceWords;

class VerbForm
{

    /**
     * @param SentenceWords $words
     * @return string
     */
    public function getIngForm(SentenceWords $words): string
    {
        return $words->getVerb() . 'ing';
    }

    /**
     * @param SentenceWords $words
     * @return string
     */
    public function getVerbThirdForm(SentenceWords $words): string
    {
        $verb = $words->getVerb();
        if ('see' === $verb) {
            $thirdForm = 'seen';
        } else {
            $thirdForm = $verb . 'ed';
        }
        return $thirdForm;
    }
}
