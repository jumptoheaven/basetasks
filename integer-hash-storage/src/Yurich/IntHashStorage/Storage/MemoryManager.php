<?php

namespace Yurich\IntHashStorage\Storage;

use InvalidArgumentException;
use Yurich\IntHashStorage\Bucket\ExportBinaryInterface;
use Yurich\IntHashStorage\Bucket\Factory\KeyValueBucketFactory;
use Yurich\IntHashStorage\Bucket\Factory\RefBucketFactory;
use Yurich\IntHashStorage\Bucket\KeyValueBucket;
use Yurich\IntHashStorage\Bucket\RefBucket;

class MemoryManager
{

    /**
     * @var resource
     */
    private $shmId;
    /**
     * @var StorageSettings
     */
    private StorageSettings $settings;
    private int $countUsedRefBucket;
    private int $countUsedKeyValueBucket;

    /**
     * @param resource $shmId
     * @return static
     */
    public static function create($shmId): self
    {
        $settings = StorageSettings::create(shmop_size($shmId));
        return new self($shmId, $settings);
    }

    /**
     * @param resource $shmId
     * @param StorageSettings $settings
     */
    public function __construct($shmId, StorageSettings $settings)
    {
        if (!is_resource($shmId) || get_resource_type($shmId) !== 'shmop') {
            throw new InvalidArgumentException('MemoryManager requires shared memory resource');
        }
        $this->shmId = $shmId;
        $this->settings = $settings;
        $this->countUsedRefBucket = 0;
        $this->countUsedKeyValueBucket = 0;
    }

    /**
     * @param int $key произвольный ключ
     * @param int $value произвольное значение
     * @return int|null предыдущее значение
     */
    public function put(int $key, int $value): ?int
    {
        $this->checkFullStorage();

        $refBucket = $this->getRefBucket($key);
        var_dump([
            '$this->settings->getMaxCountRefBuckets()' => $this->settings->getMaxCountRefBuckets(),
            'key' => $key,
            'offset' => $this->settings->getOffsetForRefBucket($key),
            'buckRefLen' => RefBucket::getLength(),
            'resOffset' => $this->settings->getOffsetForRefBucket($key) * RefBucket::getLength(),
        ]);
        var_dump($refBucket);
        if ($refBucket->isEmptyTargetRef()) {
            $this->countUsedRefBucket++;
            $keyValueRef = $this->settings->getSizeForRefsPartition() + $this->countUsedRefBucket * KeyValueBucket::getLength();
            $keyValueBucket = new KeyValueBucket($key, $value, ExportBinaryInterface::NULL_REF, $keyValueRef);
            $this->writeBucket($keyValueBucket, $keyValueRef);
            $refBucket = $refBucket->withNewTargetRef($keyValueRef);
            $this->writeBucket($refBucket, $refBucket->getThisBucketRef());
        } else {
            $existedKeyValueBucket = $this->getIterateKeyValueBucket($refBucket, $key);
        }

        return 0;
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

        return $keyValueBucket->getValue();
    }


    /**
     * @param RefBucket $refBucket
     * @param int|null $key
     * @return KeyValueBucket
     */
    private function getIterateKeyValueBucket(RefBucket $refBucket, ?int $key): KeyValueBucket
    {
        $factory = new KeyValueBucketFactory();
        $offset = $refBucket->getTargetRef();
        do {
            $bucketLen = $factory->getLength();
            $binary = shmop_read($this->shmId, $offset * $bucketLen, $bucketLen);
            if ($binary === false) {
                throw new \RuntimeException("There is an error occurs when we read shared memory $offset by $bucketLen");
            }
            $keyValueBucket = $factory->createFromBinary($binary, $offset);
            $offset = $keyValueBucket->getNextRef();
        } while ($keyValueBucket->getKey() === $key || !$offset);
        return $keyValueBucket;
    }

    private function writeBucket(ExportBinaryInterface $keyValueBucket, int $reference): void
    {
        $binary = $keyValueBucket->toBinary();
        $savedLen = shmop_write($this->shmId, $binary, $reference);
        $lenForSaved = strlen($binary);
        if ($lenForSaved !== $savedLen) {
            throw new \RuntimeException("Quantity saved bytes doesnt equal transferred: $lenForSaved vs $savedLen");
        }
    }

    /**
     * @param int $key
     * @return RefBucket
     */
    private function getRefBucket(int $key): RefBucket
    {
        $offset = $this->settings->getOffsetForRefBucket($key);
        $factory = new RefBucketFactory();
        $length = $factory->getLength();
        return $factory->createFromBinary(
            shmop_read($this->shmId, $offset * $length, $length),
            $offset
        );
    }

    private function checkFullStorage(): void
    {
        if ($this->countUsedRefBucket >= $this->settings->getMaxCountRefBuckets()) {
            throw new \RuntimeException('Hash storage is full (by refs buckets)');
        }
        if ($this->countUsedKeyValueBucket >= $this->settings->getMaxCountKeyValueBuckets()) {
            throw new \RuntimeException('Hash storage is full (by key-values buckets)');
        }
    }
}
