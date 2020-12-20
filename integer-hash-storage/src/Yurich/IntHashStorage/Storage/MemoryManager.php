<?php

namespace Yurich\IntHashStorage\Storage;

use InvalidArgumentException;
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
        return ;
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

    /**
     * @param int $key
     * @return RefBucket
     */
    private function getRefBucket(int $key): RefBucket
    {
        $offsetForRefBucket = $this->settings->getOffsetForRefBucket($key);
        return RefBucket::createFromBinary(
            shmop_read($this->shmId, $offsetForRefBucket * RefBucket::getLength(), RefBucket::getLength()),
            $offsetForRefBucket
        );
    }
}
