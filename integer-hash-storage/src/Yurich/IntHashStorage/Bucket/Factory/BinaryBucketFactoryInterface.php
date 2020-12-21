<?php

namespace Yurich\IntHashStorage\Bucket\Factory;

use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;

interface BinaryBucketFactoryInterface
{

    public function getLength(): int;

    public function createFromBinary(string $binary, int $thisBucketRef): BinaryBucketInterface;
}
