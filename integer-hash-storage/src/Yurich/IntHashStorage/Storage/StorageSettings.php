<?php

namespace Yurich\IntHashStorage\Storage;

use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;

class StorageSettings
{

    private int $byteSize;
    private int $maxCountBucketPairs;

    public function __construct(int $byteSize)
    {
        $this->byteSize = $byteSize;
        $this->maxCountBucketPairs = $this->getMaxCountBucketPairs();
    }

    public function getMaxCountRefBuckets(): int
    {
        return $this->maxCountBucketPairs;
    }

    public function getMaxCountKeyValueBuckets(): int
    {
        return $this->maxCountBucketPairs;
    }

    public function getSizeForRefsPartition(): int
    {
        return RefBucket::getLength() * $this->maxCountBucketPairs;
    }

    private function getMaxCountBucketPairs(): int
    {
        // @TODO Sum by two bucket lengths isn't universal formula (maybe). But for my case it's work,
        //      because I work with integers only.
        //      Main idea: For the one key-value I need space for the one ref bucket and for the one key-value bucket.
        //      In that way in hash storage I can store `StorageSize // (RefSize + KeyValueSize)` key-values pairs.
        return intdiv($this->byteSize, KeyValueBucket::getLength() + RefBucket::getLength());
    }
}
