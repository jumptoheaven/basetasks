<?php

declare(strict_types=1);

namespace Yurich\Test;

use PHPUnit\Framework\TestCase;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;

class BucketTest extends TestCase
{

    public function testBucketsLength(): void
    {
        $this->assertEquals(PHP_INT_SIZE * 3, KeyValueBucket::getBucketLength());
        $this->assertEquals(PHP_INT_SIZE, RefBucket::getLength());
    }
}
