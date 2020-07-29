<?php

namespace App;

class ActiveSpeech
{

    public function presentSimple(string $subject, string $predicate, string $addition): string
    {
        if (in_array($subject, ['it', 'he', 'she',])) {
            $predicate .= 's';
        }
        return $subject . ' ' . $predicate . ' ' . $addition;
    }

    public function presentContinues(string $subject, string $predicate, string $addition): string
    {
        if (in_array($subject, ['it', 'he', 'she',])) {
            $predicate = 'is ' . $predicate;
        } elseif (in_array($subject, ['I', 'i',])) {
            $predicate = 'am ' . $predicate;
        } else {
            $predicate = 'are ' . $predicate;
        }
        $predicate .= 'ing';
        return $subject . ' ' . $predicate . ' ' . $addition;
    }
}