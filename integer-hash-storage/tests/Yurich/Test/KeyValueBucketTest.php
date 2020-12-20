<?php

declare(strict_types=1);

namespace Yurich\Test;

use PHPUnit\Framework\TestCase;
use Yurich\IntHashStorage\KeyValueBucket;

class KeyValueBucketTest extends TestCase
{

    public function testBucketLength(): void
    {
        $expected = 1 + PHP_INT_SIZE * 2;
        $this->assertEquals($expected, KeyValueBucket::getBucketLength());
    }
}
