<?php

namespace Yurich\IntHashStorage\Storage;

use Yurich\IntHashStorage\Bucket\Factory\RefBucketFactory;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;

class StorageState
{
    private StorageSettings $settings;
    private int $countUsedRefBucket;
    private int $countUsedKeyValueBucket;

    public function __construct(StorageSettings $settings)
    {
        $this->settings = $settings;
        $this->countUsedRefBucket = 0;
        $this->countUsedKeyValueBucket = 0;
    }

    public function checkFullStorage(): void
    {
        if ($this->countUsedRefBucket >= $this->settings->getMaxCountRefBuckets()) {
            throw new \RuntimeException('Hash storage is full (by refs buckets)');
        }
        if ($this->countUsedKeyValueBucket >= $this->settings->getMaxCountKeyValueBuckets()) {
            throw new \RuntimeException('Hash storage is full (by key-values buckets)');
        }
    }

    public function reserveKeyValueRef(): int
    {
        $this->countUsedRefBucket++;
        return $this->settings->getSizeForRefsPartition() + $this->countUsedRefBucket * KeyValueBucket::getLength();
    }


    /**
     * @param int $key
     * @return int
     */
    public function refForRefBucket(int $key): int
    {
        return $this->settings->getOffsetForRefBucket($key) * RefBucket::getLength();
    }
}
