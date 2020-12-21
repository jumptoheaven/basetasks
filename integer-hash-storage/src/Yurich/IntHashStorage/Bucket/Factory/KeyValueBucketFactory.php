<?php

namespace Yurich\IntHashStorage\Bucket\Factory;

use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;

class KeyValueBucketFactory implements BinaryBucketFactoryInterface
{

    public function getLength(): int
    {
        return KeyValueBucket::getLength();
    }

    /**
     * @param string $binary
     * @param int $thisBucketRef
     * @return BinaryBucketInterface|KeyValueBucket
     */
    public function createFromBinary(string $binary, int $thisBucketRef): BinaryBucketInterface
    {
        // php -r '$a=234; $b=564; $c=799; $p=pack("q*", $a, $b, $c); $u=unpack("q*", $p); var_dump($u);'
        $unpack = unpack('q*', $binary);
        $key = $unpack[1] ?? 0;
        $value = $unpack[2] ?? 0;
        $nextRef = $unpack[3] ?? 0;
        return new KeyValueBucket($key, $value, $nextRef, $thisBucketRef);
    }

    public function createEmpty(int $key): KeyValueBucket
    {
        return new KeyValueBucket($key, 0);
    }

    public function create(int $key, int $value, int $storedRef): KeyValueBucket
    {
        return new KeyValueBucket($key, $value, BinaryBucketInterface::NULL_REF, $storedRef);
    }
}
