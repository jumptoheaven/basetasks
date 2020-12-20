<?php

namespace Yurich\IntHashStorage\Storage;

use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;

class StorageSettings
{

    private int $byteSize;

    public static function create(int $byteSize): self
    {
        return new self($byteSize);
    }

    public function __construct(int $byteSize)
    {
        $this->byteSize = $byteSize;
    }

    public function generateHash(int $key): string
    {
        // https://softwareengineering.stackexchange.com/a/145633/262333
        return (string)hash('fnv1a64', (string)$key, $binary = true);
    }

    public function getOffsetForRefBucket(int $key): int
    {
        return $this->generateHash($key) % $this->getMaxCountRefBuckets();
    }

    public function getMaxCountRefBuckets(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            $maxCount = $this->getMaxCountIntegerSize();
        }
        return $maxCount;
    }

    public function getMaxCountKeyValueBuckets(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            $maxCount = $this->getMaxCountIntegerSize();
        }
        return $maxCount;
    }

    private function getMaxCountIntegerSize(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            // @TODO Sum by two bucket isn't universal formula (maybe). But for my case it's work,
            //      because I work with integers only.
            $maxCount = intdiv($this->byteSize, KeyValueBucket::getBucketLength() + RefBucket::getBucketLength());
        }
        return $maxCount;
    }
}
