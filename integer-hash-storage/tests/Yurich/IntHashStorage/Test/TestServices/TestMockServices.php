<?php

namespace Yurich\IntHashStorage\Test\TestServices;

use Yurich\IntHashStorage\IntIntHashStorage;

class TestMockServices
{

    public function createTestHashStorage(int $byteSize): IntIntHashStorage
    {
        $shmKey = ftok(__FILE__, 'k');

        $shmId = \shmop_open($shmKey, "c", 0644, 1);
        \shmop_delete($shmId);
        \shmop_close($shmId);

        $shmId = shmop_open($shmKey, "c", 0644, $byteSize);
        return new IntIntHashStorage($shmId, $byteSize);
    }
}
