<?php

namespace Yurich\IntHashStorage\Bucket\Factory;

use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;
use Yurich\IntHashStorage\Bucket\RefBucket;

class RefBucketFactory implements BinaryBucketFactoryInterface
{
    public function getLength(): int
    {
        return RefBucket::getLength();
    }

    /**
     * @param string $binary
     * @param int $thisBucketRef
     * @return RefBucket
     */
    public function createFromBinary(string $binary, int $thisBucketRef): BinaryBucketInterface
    {
        $unpack = unpack('q', $binary);
//        var_dump($unpack, $binary, strlen($binary), bin2hex($binary));
        $targetRef = $unpack[1] ?? 0;
        return new RefBucket($targetRef, $thisBucketRef);
    }
}
