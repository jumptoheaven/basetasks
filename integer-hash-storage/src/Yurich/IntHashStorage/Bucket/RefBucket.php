<?php

namespace Yurich\IntHashStorage\Bucket;

class RefBucket
{

    private int $targetRef;
    private int $thisBucketRef;

    public static function createFromBinary(string $binary, int $thisBucketRef): self
    {
        $unpack = unpack('q', $binary);
        var_dump($unpack, $binary, strlen($binary), bin2hex($binary));
        $targetRef = $unpack[1] ?? 0;
        return new self($targetRef, $thisBucketRef);
    }

    public static function getLength(): int
    {
        return PHP_INT_SIZE;
    }

    public function __construct(int $targetRef, int $thisBucketRef)
    {
        $this->targetRef = $targetRef;
        $this->thisBucketRef = $thisBucketRef;
    }

    /**
     * @return int
     */
    public function getTargetRef(): int
    {
        return $this->targetRef;
    }

    /**
     * @return int
     */
    public function getThisBucketRef(): int
    {
        return $this->thisBucketRef;
    }

    public function isEmptyTargetRef(): bool
    {
        return $this->targetRef === 0;
    }

    public function addTargetRef(int $targetRef): self
    {
        return new self($targetRef, $this->thisBucketRef);
    }

    /**
     * @return string
     *
     *  php -r '$i=-11325; $b=pack("q",$i); $u=unpack("q", $b); var_dump($i, bin2hex($b), strlen($b), $u);'
     */
    public function toBinary(): string
    {
        return $this->packInt($this->targetRef);
    }

    private function packInt(int $val): string
    {
        return pack("q", $val);
        //return pack("q", $val ?: 0);
    }
}
