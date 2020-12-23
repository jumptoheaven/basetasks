<?php

namespace Yurich\IntHashStorage\Test\TestServices;

use Yurich\IntHashStorage\Bucket\RefBucket;
use Yurich\IntHashStorage\Storage\Service\HashService;

class HashServiceCollisions extends HashService
{

    public function getOffsetForRefBucket(int $key): int
    {
        $fixedRef = 5 * RefBucket::getLength();
        if ($fixedRef > $this->settings->getSizeForRefsPartition()) {
            $fixedRef = 0;
        }
        return $fixedRef;
    }
}
