<?php

namespace Yurich\IntHashStorage;

class RunTest
{

    public function run()
    {
        $shmKey = ftok(__FILE__, 'k');
        $size = 1024 * 1024; // 1MB
        $shmId = shmop_open($shmKey, "c", 0644, $size);
        $storage = new IntIntHashStorage($shmId, $size);
    }
}
