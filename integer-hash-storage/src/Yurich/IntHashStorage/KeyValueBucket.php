<?php

namespace Yurich\IntHashStorage;

class KeyValueBucket
{

    public const BUCKET_TYPE = 'k'; // '\x01';

//    private string $bucketType;
    private ?int $key;
    private ?int $value;

    public function __construct(?int $key, ?int $value)
    {
        $this->key = $key;
        $this->value = $value;
    }

    /**
     * @return int|null
     */
    public function getKey(): ?int
    {
        return $this->key;
    }

    /**
     * @return int|null
     */
    public function getValue(): ?int
    {
        return $this->value;
    }

    /**
     * @return string
     *
     *  php -r '$i=-11325; $b=pack("q",$i); $u=unpack("q", $b); var_dump($i, bin2hex($b), strlen($b), $u);'
     */
    public function toBinary(): string
    {
        return self::BUCKET_TYPE . $this->packInt($this->key) . $this->packInt($this->value);
    }

    public static function getBucketLength(): int
    {
        return 1 + PHP_INT_SIZE * 2;
    }

    private function packInt(?int $val): string
    {
        return pack("q", $val ?: 0);
    }
}
