<?php

namespace App\Formatter;

class OutputFormatter
{

    public function arrayToString(array $words): string
    {
        return join(' ', $words);
    }

    public function upperFirstSymbol(string $phrase): string
    {
        return ucfirst($phrase);
    }
}
