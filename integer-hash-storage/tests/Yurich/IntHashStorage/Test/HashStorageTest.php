<?php

namespace Yurich\IntHashStorage\Test;

use PHPUnit\Framework\TestCase;
use Yurich\IntHashStorage\Test\TestServices\TestMockServices;

class HashStorageTest extends TestCase
{

    private TestMockServices $mockServices;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->mockServices = new TestMockServices();
    }

    public function testSimplePutGet()
    {
        $storage = $this->mockServices->createTestHashStorage(1024 * 1024);
        self::assertEquals(null, $storage->put(2, 3));
        self::assertEquals(3, $storage->get(2));
        self::assertEquals(3, $storage->get(2));
        self::assertEquals(null, $storage->get(7));
        self::assertEquals(3, $storage->put(2, 8));
        self::assertEquals(8, $storage->get(2));

        self::assertEquals(null, $storage->get(\PHP_INT_MAX));
        self::assertEquals(null, $storage->put(\PHP_INT_MAX, 8));
        self::assertEquals(8, $storage->get(\PHP_INT_MAX));
    }

    public function testCollisions()
    {

    }
}
