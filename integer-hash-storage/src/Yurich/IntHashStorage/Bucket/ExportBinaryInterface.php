<?php

namespace Yurich\IntHashStorage\Bucket;

interface ExportBinaryInterface
{

    public const NULL_REF = -1;

    public function toBinary(): string;
}
