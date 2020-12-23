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
        if (!$this->isShmopResource($shmId)) {
            //if (!($shmId instanceof \Shmop)) { // php8
            throw new InvalidArgumentException('MemoryManager requires shared memory resource');
        }
        $this->shmId = $shmId;
    }

    public function createSettings(): StorageSettings
    {
        return new StorageSettings($this->getByteSize());
    }

    /**
     * @param BinaryBucketFactoryInterface $factory
     * @param int $ref
     * @return BinaryBucketInterface
     */
    public function readBucket(BinaryBucketFactoryInterface $factory, int $ref): BinaryBucketInterface
    {
        $bucketLen = $factory->getLength();
        $binary = shmop_read($this->shmId, $ref, $bucketLen);
        if ($binary === false) {
            throw new \RuntimeException("There is an error occurs when we read shared memory $ref by $bucketLen");
        }
        return $factory->createFromBinary($binary, $ref);
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

    /**
     * @param $shmId
     * @return bool
     */
    private function isShmopResource($shmId): bool
    {
        return is_resource($shmId) && get_resource_type($shmId) === 'shmop';
    }
}
