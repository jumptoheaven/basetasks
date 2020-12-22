<?php

namespace Yurich\IntHashStorage\Test;

use PHPUnit\Framework\TestCase;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;
use Yurich\IntHashStorage\Storage\StorageSettings;
use const PHP_INT_SIZE;

class StorageSettingsTest extends TestCase
{

    public function testBucketsLength(): void
    {
        $this->assertEquals(PHP_INT_SIZE * 3, KeyValueBucket::getLength());
        $this->assertEquals(PHP_INT_SIZE, RefBucket::getLength());
        $this->assertEquals(3 * RefBucket::getLength(), KeyValueBucket::getLength());
    }

    public function testMaxCountBucketPairs(): void
    {
        $storageByteSize = 1024;
        $settings = new StorageSettings($storageByteSize);
        $pairSize = 4 * PHP_INT_SIZE;
        $expected = \intdiv($storageByteSize, $pairSize);

        $this->assertEquals($expected, $settings->getMaxCountBucketPairs(), 'getMaxCountBucketPairs');
        $this->assertLessThanOrEqual(
            $storageByteSize,
            $expected * $settings->getMaxCountBucketPairs(),
            'Storage size is greater or equal than max count bucket pairs'
        );
    }
}
