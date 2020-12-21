<?php

namespace Yurich\IntHashStorage\Bucket;

class KeyValueBucket extends AbstractBinaryBucket
{

    private int $key;
    private int $value;
    private int $nextRef;
    private int $thisBucketRef;

    /**
     * @return int
     * 64 bit:  8 * 3 = 24
     * 32 bit:  4 * 3 = 12
     */
    public static function getLength(): int
    {
        return  PHP_INT_SIZE * 3;
    }

    public function __construct(int $key, int $value, int $nextRef = self::NULL_REF, int $thisBucketRef = self::NULL_REF)
    {
        $this->key = $key;
        $this->value = $value;
        $this->nextRef = $nextRef;
        $this->thisBucketRef = $thisBucketRef;
    }

    /**
     * @return int|null
     */
    public function getKey(): int
    {
        return $this->key;
    }

    /**
     * @return int
     */
    public function getValue(): int
    {
        return $this->value;
    }

    /**
     * @return int
     */
    public function getNextRef(): int
    {
        return $this->nextRef;
    }

    /**
     * @return int
     */
    public function getThisBucketRef(): int
    {
        return $this->thisBucketRef;
    }

    /**
     * @return string
     *
     * php -r '$i=-11325; $b=pack("q",$i); $u=unpack("q", $b); var_dump($i, bin2hex($b), strlen($b), $u);'
     * php -r '$a=234; $b=564; $c=799; $p=pack("q*", $a, $b, $c); $u=unpack("q*", $p); var_dump($u);'
     */
    public function toBinary(): string
    {
        return pack("q*", $this->key, $this->value, $this->nextRef);
    }

    public function withNextRef(int $ref): self
    {
        return new self($this->key, $this->value, $ref, $this->thisBucketRef);
    }

    public function withValue(int $value): self
    {
        return new self($this->key, $value, $this->nextRef, $this->thisBucketRef);
    }
}
