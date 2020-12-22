<?php

namespace Yurich\IntHashStorage\Storage;

use InvalidArgumentException;
use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;
use Yurich\IntHashStorage\Bucket\Factory\BinaryBucketFactoryInterface;

class SharedMemoryManager
{

    /**
     * @var resource
     */
    private $shmId;

    /**
     * @param resource $shmId
     */
    public function __construct($shmId)
    {
        if (!is_resource($shmId) || get_resource_type($shmId) !== 'shmop') {
            throw new InvalidArgumentException('MemoryManager requires shared memory resource');
        }
        $this->shmId = $shmId;
    }

    /**
     * @param BinaryBucketFactoryInterface $factory
     * @param int $offset
     * @return BinaryBucketInterface
     */
    public function readBucket(BinaryBucketFactoryInterface $factory, int $offset): BinaryBucketInterface
    {
        $bucketLen = $factory->getLength();
        \var_dump($this->shmId, \json_encode([$offset, $bucketLen, $offset * $bucketLen]));
        $binary = shmop_read($this->shmId, $offset * $bucketLen, $bucketLen);
        if ($binary === false) {
            throw new \RuntimeException("There is an error occurs when we read shared memory $offset by $bucketLen");
        }
        return $factory->createFromBinary($binary, $offset);
    }

    /**
     * @param BinaryBucketInterface $bucket
     */
    public function writeBucket(BinaryBucketInterface $bucket): void
    {
        if ($bucket->getThisBucketRef() === BinaryBucketInterface::NULL_REF) {
            throw new \RuntimeException('Null reference is gotten for saving bucket');
        }
        $binary = $bucket->toBinary();
        $savedLen = shmop_write($this->shmId, $binary, $bucket->getThisBucketRef());
        $lenForSaved = strlen($binary);
        if ($lenForSaved !== $savedLen) {
            throw new \RuntimeException("Quantity saved bytes doesnt equal transferred: $lenForSaved vs $savedLen");
        }
    }

    public function getByteSize(): int
    {
        return shmop_size($this->shmId);
    }
}
