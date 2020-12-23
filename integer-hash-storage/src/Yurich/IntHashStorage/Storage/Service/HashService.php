<?php

namespace Yurich\IntHashStorage\Storage\Service;

use Yurich\IntHashStorage\Storage\StorageSettings;

class HashService
{

    /**
     * @var StorageSettings
     */
    private StorageSettings $settings;

    public function __construct(StorageSettings $settings)
    {
        $this->settings = $settings;
    }

    private function generateHash(int $key): string
    {
        // https://softwareengineering.stackexchange.com/a/145633/262333
        return hash('fnv1a64', (string)$key, $binary = false);
    }

    public function getOffsetForRefBucket(int $key): int
    {
        // It's simple way calculating the offset reference for storing RefBucket is the remainder of the division.
        // I need to apply abs() and (int) function because hexdec() can return negative or float number for some
        // 16-th code string (if they doesn't fit in signed positive integer).
        return abs((int)hexdec($this->generateHash($key)) % $this->settings->getMaxCountRefBuckets());
    }
}
