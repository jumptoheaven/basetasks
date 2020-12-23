<?php

declare(strict_types=1);

namespace Yurich\IntHashStorage\Storage;

use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;
use Yurich\IntHashStorage\Bucket\Factory\KeyValueBucketFactory;
use Yurich\IntHashStorage\Bucket\Factory\RefBucketFactory;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;
use Yurich\IntHashStorage\Storage\Service\HashService;

class MemoryManager
{

    private SharedMemoryManager $sharedMemoryManager;
    private StorageState $state;
    private KeyValueBucketFactory $keyValueBucketFactory;
    private RefBucketFactory $refBucketFactory;

    /**
     * @param resource $shmId
     * @return static
     */
    public static function create($shmId): self
    {
        $sharedMemoryManager = new SharedMemoryManager($shmId);
        $settings = $sharedMemoryManager->createSettings();
        $hashService = new HashService($settings);
        $storageState = new StorageState($settings, $hashService);
        return new self($sharedMemoryManager, $storageState);
    }

    /**
     * @param SharedMemoryManager $sharedMemoryManager
     * @param StorageState $storageState
     */
    public function __construct(SharedMemoryManager $sharedMemoryManager, StorageState $storageState)
    {
        $this->sharedMemoryManager = $sharedMemoryManager;
        $this->state = $storageState;
        $this->keyValueBucketFactory = new KeyValueBucketFactory();
        $this->refBucketFactory = new RefBucketFactory();
    }

    /**
     * @param int $key произвольный ключ
     * @param int $value произвольное значение
     * @return int|null предыдущее значение
     */
    public function put(int $key, int $value): ?int
    {
        $oldValue = null;
        $this->state->checkFullStorage();

        $refBucket = $this->getRefBucket($key);
        $keyValueBucket = $this->keyValueBucketFactory->createEmpty($key);
        if (!$refBucket->isEmptyTargetRef()) {
            $keyValueBucket = $this->getIterateKeyValueBucket($refBucket, $key);
            if ($keyValueBucket->hasStoringRef()) {
                $oldValue = $keyValueBucket->getValue();
            }
        }
        if (!$keyValueBucket->hasStoringRef()) {
            $keyValueBucket = $this->keyValueBucketFactory->create($key, $value, $this->state->reserveKeyValueRef());
        }
        $keyValueBucket = $keyValueBucket->withValue($value);
        $this->sharedMemoryManager->writeBucket($keyValueBucket);
        $refBucket = $refBucket->withNewTargetRef($keyValueBucket);
        $this->sharedMemoryManager->writeBucket($refBucket);
        return $oldValue;
    }

    /**
     * @param int $key ключ
     * @return int|null значение, сохраненное ранее по этому ключу
     */
    public function get(int $key): ?int
    {
        $refBucket = $this->getRefBucket($key);
        if ($refBucket->isEmptyTargetRef()) {
            return null;
        }
        $keyValueBucket = $this->getIterateKeyValueBucket($refBucket, $key);
        return $keyValueBucket->hasStoringRef() ? $keyValueBucket->getValue() : null;
    }


    /**
     * @param RefBucket $refBucket
     * @param int|null $key
     * @return KeyValueBucket
     */
    private function getIterateKeyValueBucket(RefBucket $refBucket, ?int $key): KeyValueBucket
    {
        $ref = $refBucket->getTargetRef();
        if ($ref === BinaryBucketInterface::NULL_REF) {
            return $this->keyValueBucketFactory->createEmpty($key);
        }
        do {
            /** @var KeyValueBucket $keyValueBucket */
            $keyValueBucket = $this->sharedMemoryManager->readBucket($this->keyValueBucketFactory, $ref);
            $ref = $keyValueBucket->getNextRef();
        } while ($keyValueBucket->getKey() === $key && $ref !== BinaryBucketInterface::NULL_REF);
        if ($keyValueBucket->getKey() !== $key) {
            $keyValueBucket = $this->keyValueBucketFactory->createEmpty($key);
        }
        return $keyValueBucket;
    }

    /**
     * @param int $key
     * @return RefBucket
     */
    private function getRefBucket(int $key): RefBucket
    {
        /** @var RefBucket $bucket */
        $bucket = $this->sharedMemoryManager->readBucket($this->refBucketFactory, $this->state->refForRefBucket($key));
        return $bucket;
    }
}
