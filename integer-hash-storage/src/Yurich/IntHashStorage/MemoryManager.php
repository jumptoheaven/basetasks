<?php

namespace Yurich\IntHashStorage;

class MemoryManager
{

    public function generateHash(string $data): string
    {
        // https://softwareengineering.stackexchange.com/a/145633/262333
        return (string) hash('fnv1a64', $data, $binary = true);
    }
}
