<?php

namespace Yurich\IntHashStorage\Bucket;

abstract class AbstractBinaryBucket implements BinaryBucketInterface
{

    final public function hasStoringRef(): bool
    {
        return $this->getThisBucketRef() >= 0;
    }
}
