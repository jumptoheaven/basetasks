<?php

namespace Yurich\IntHashStorage\Test\TestServices;

use Yurich\IntHashStorage\IntIntHashStorage;
use Yurich\IntHashStorage\Storage\MemoryManager;
use Yurich\IntHashStorage\Storage\SharedMemoryManager;
use Yurich\IntHashStorage\Storage\StorageState;
use function shmop_close;
use function shmop_delete;
use function shmop_open;

class TestMockServices
{

    public function createMemoryManager(int $byteSize): MemoryManager
    {
        $shmId = $this->createSharedMemoryResource($byteSize);
        return MemoryManager::create($shmId);
    }

    public function createMemoryManagerCollisions(int $byteSize): MemoryManager
    {
        $shmId = $this->createSharedMemoryResource($byteSize);
        $sharedMemoryManager = new SharedMemoryManager($shmId);
        $settings = $sharedMemoryManager->createSettings();
        $hashService = new HashServiceCollisions($settings);
        $storageState = new StorageState($settings, $hashService);
        return new MemoryManager($sharedMemoryManager, $storageState);
    }

    /**
     * @param int $byteSize
     * @return false|resource|\Shmop
     */
    private function createSharedMemoryResource(int $byteSize)
    {
        $shmKey = ftok(__FILE__, 'k');

        // I have to delete previous shared memory segment
        $shmId = shmop_open($shmKey, "c", 0644, 1);
        shmop_delete($shmId);
        shmop_close($shmId);

        $shmId = shmop_open($shmKey, "c", 0644, $byteSize);
        return $shmId;
    }
}
