<?php

namespace Yurich\IntHashStorage\Bucket\Factory;

use Yurich\IntHashStorage\Bucket\ExportBinaryInterface;
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
     * @return ExportBinaryInterface|KeyValueBucket
     */
    public function createFromBinary(string $binary, int $thisBucketRef):  ExportBinaryInterface
    {
        // php -r '$a=234; $b=564; $c=799; $p=pack("q*", $a, $b, $c); $u=unpack("q*", $p); var_dump($u);'
        $unpack = unpack('q*', $binary);
        $key = $unpack[1] ?? 0;
        $value = $unpack[2] ?? 0;
        $nextRef = $unpack[3] ?? 0;
        return new KeyValueBucket($key, $value, $nextRef, $thisBucketRef);
    }
}
