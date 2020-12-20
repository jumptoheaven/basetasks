<?php

namespace Yurich\IntHashStorage\Bucket;

class RefBucket
{

//    public const BUCKET_TYPE = 'r'; // '\x01';

    private int $ref;

    public function __construct(int $ref)
    {
        $this->ref = $ref;
    }

    /**
     * @return int
     */
    public function getRef(): int
    {
        return $this->ref;
    }

    public static function getBucketLength(): int
    {
        return /*strlen(self::BUCKET_TYPE) + */ PHP_INT_SIZE;
    }

}
