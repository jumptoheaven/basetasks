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

    public function getOffsetForRefBucket(int $key): int
    {
        // It's simple way calculating the offset reference for storing RefBucket is the remainder of the division.
        // I need to apply abs() and (int) function because hexdec() can return negative or float number for some
        // 16-th code string (if they doesn't fit in signed positive integer).
        return abs((int)hexdec($this->generateHash($key)) % $this->getMaxCountRefBuckets());
    }

    public function getMaxCountRefBuckets(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            $maxCount = $this->getMaxCountKeyValuePairs();
        }
        return $maxCount;
    }

    public function getMaxCountKeyValueBuckets(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            $maxCount = $this->getMaxCountKeyValuePairs();
        }
        return $maxCount;
    }

    public function getSizeForRefsPartition(): int
    {
        return RefBucket::getLength() * $this->getMaxCountRefBuckets();
    }

    private function getMaxCountKeyValuePairs(): int
    {
        static $maxCount;
        if (is_null($maxCount)) {
            // @TODO Sum by two bucket lengths isn't universal formula (maybe). But for my case it's work,
            //      because I work with integers only.
            //      Main idea: For the one key-value I need space for the one ref bucket and for the one key-value bucket.
            //      In that way in hash storage I can store `StorageSize // (RefSize + KeyValueSize)` key-values pairs.
            $maxCount = intdiv($this->byteSize, KeyValueBucket::getLength() + RefBucket::getLength());
        }
        return $maxCount;
    }

    private function generateHash(int $key): string
    {
        // https://softwareengineering.stackexchange.com/a/145633/262333
        return hash('fnv1a64', (string)$key, $binary = false);
    }
}
