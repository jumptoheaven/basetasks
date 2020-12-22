<?php

namespace Yurich\IntHashStorage\Test;

use PHPUnit\Framework\TestCase;
use Yurich\IntHashStorage\Bucket\BinaryBucketInterface;
use Yurich\IntHashStorage\Bucket\RefBucket;

class BucketTest extends TestCase
{

    public function test()
    {
        // php -r '$i=-11325; $b=pack("q",$i); $u=unpack("q", $b); var_dump($i, bin2hex($b), strlen($b), $u);'
        $ref = 11325;
        $refBucket = new RefBucket($ref, BinaryBucketInterface::NULL_REF);
        $pack = pack("q", $ref);
        $this->assertEquals($pack, $refBucket->toBinary(), "pack: " . \bin2hex($pack));
    }
}
