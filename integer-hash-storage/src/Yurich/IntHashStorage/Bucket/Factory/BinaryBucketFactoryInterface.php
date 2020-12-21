<?php

namespace Yurich\IntHashStorage\Bucket\Factory;

use Yurich\IntHashStorage\Bucket\ExportBinaryInterface;

interface BinaryBucketFactoryInterface
{

    public function getLength(): int;

    public function createFromBinary(string $binary, int $thisBucketRef): ExportBinaryInterface;
}
