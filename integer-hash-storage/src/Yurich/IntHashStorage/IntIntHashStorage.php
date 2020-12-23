<?php

declare(strict_types=1);

namespace Yurich\IntHashStorage;

use InvalidArgumentException;
use Yurich\IntHashStorage\Storage\MemoryManager;

class IntIntHashStorage
{
    private MemoryManager $memoryManager;

    /**
     * @param resource $shmId результат вызова \shmop_open
     * @param int $size размер зарезервированного блока в разделяемой памяти (~100GB)
     * Second parameter doesn't use because is used function shmop_size($shmId)
     */
    public function __construct($shmId, int $size)
    {
        $this->memoryManager = MemoryManager::create($shmId);
    }

    /**
     * @param int $key произвольный ключ
     * @param int $value произвольное значение
     * @return int|null предыдущее значение
     */
    public function put(int $key, int $value): ?int
    {
        return $this->memoryManager->put($key, $value);
    }

    /**
     * @param int $key ключ
     * @return int|null значение, сохраненное ранее по этому ключу
     */
    public function get(int $key): ?int
    {
        return $this->memoryManager->get($key);
    }
}
