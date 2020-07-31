<?php

namespace App\Model;

class SentenceWords
{

    /** @var string */
    private $subject;
    /** @var string */
    private $verb;
    /** @var string */
    private $addition;

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param string $subject
     */
    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    /**
     * @return string
     */
    public function getVerb(): string
    {
        return $this->verb;
    }

    /**
     * @param string $verb
     */
    public function setVerb(string $verb): void
    {
        $this->verb = $verb;
    }

    /**
     * @return string
     */
    public function getAddition(): string
    {
        return $this->addition;
    }

    /**
     * @param string $addition
     */
    public function setAddition(string $addition): void
    {
        $this->addition = $addition;
    }
}
