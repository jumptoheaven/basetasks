<?php

namespace Yurich\IntHashStorage\Bucket;

class KeyValueBucket
{

//    public const BUCKET_TYPE = 'k'; // '\x01';
    public const NULL_REF = -1;

    private int $key;
    private int $value;
    private int $nextRef;

    /**
     * @return int
     * 64 bit:  8 * 3 = 24
     * 32 bit:  4 * 3 = 12
     */
    public static function getBucketLength(): int
    {
        return  PHP_INT_SIZE * 3;
    }

    public static function createFromBinary(string $binary): self
    {
        $unpack = unpack('q/q/q/', $binary);
    }

    public function __construct(int $key, int $value, int $nextRef = self::NULL_REF)
    {
        $this->key = $key;
        $this->value = $value;
        $this->nextRef = $nextRef;
    }

    public function addNextRef(int $ref): self
    {
        return new self($this->key, $this->value, $ref);
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
     * @return string
     *
     *  php -r '$i=-11325; $b=pack("q",$i); $u=unpack("q", $b); var_dump($i, bin2hex($b), strlen($b), $u);'
     */
    public function toBinary(): string
    {
        return /*self::BUCKET_TYPE . */
            $this->packInt($this->key) . $this->packInt($this->value) . $this->packInt($this->nextRef);
    }

    private function packInt(int $val): string
    {
        return pack("q", $val);
        //return pack("q", $val ?: 0);
    }
}
