<?php

namespace App\Defenders;

class FaceDefender
{

    /**
     * @param string $subject
     * @return bool
     */
    public function isThirdFace(string $subject): bool
    {
        return in_array(strtolower($subject), ['it', 'he', 'she',]);
    }

    /**
     * @param string $subject
     * @return bool
     */
    public function isFirstFace(string $subject): bool
    {
        return in_array(strtolower($subject), ['i',]);
    }
}
