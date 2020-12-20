<?php

namespace Yurich\IntHashStorage\Bucket;

class KeyValueBucket
{

//    public const BUCKET_TYPE = 'k'; // '\x01';
    public const NULL_REF = -1;

    private int $key;
    private int $value;
    private int $nextRef;

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

    /**
     * @return int
     * 64 bit: 1 + 8 * 2 = 17
     * 32 bit: 1 + 4 * 2 = 9
     */
    public static function getBucketLength(): int
    {
        return /*strlen(self::BUCKET_TYPE) + */ PHP_INT_SIZE * 3;
    }

    private function packInt(int $val): string
    {
        return pack("q", $val);
        //return pack("q", $val ?: 0);
    }
}
