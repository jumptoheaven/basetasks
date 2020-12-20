<?php
declare(strict_types = 1);

class IntIntHashStorage
{
    /**
     * @var resource
     */
    private $shm_id;
    /**
     * @var int
     */
    private int $reservedShmByteSize;

    /**
     * @param resource $shmId результат вызова \shmop_open
     * @param int $size размер зарезервированного блока в разделяемой памяти (~100GB)
     */
    public function __construct($shmId, int $size)
    {
        if (!is_resource($shmId) || get_resource_type($shmId) !== 'sysvshm') {
            throw new InvalidArgumentException();
        }
        $this->shm_id = $shmId;
        $this->reservedShmByteSize = $size;
    }

    /**
     * @param int $key произвольный ключ
     * @param int $value произвольное значение
     * @return int|null предыдущее значение
     */
    public function put(int $key, int $value): ?int
    {
        // ...
    }

    /**
     * @param int $key ключ
     * @return int|null значение, сохраненное ранее по этому ключу
     */
    public function get(int $key): ?int
    {
        // ...
    }
}


