<?php

namespace Yurich\IntHashStorage\Bucket;

interface BinaryBucketInterface
{

    public const NULL_REF = -1;

    public function toBinary(): string;

    public function getThisBucketRef(): int;

    public function hasStoringRef(): bool;
}
