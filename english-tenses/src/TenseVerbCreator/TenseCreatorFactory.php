<?php

namespace App\TenseVerbCreator;

class TenseCreatorFactory
{

    public function createPresentPerfect(): PresentPerfectTenseCreator
    {
        return new PresentPerfectTenseCreator();
    }

    public function createPresentSimple(): PresentSimpleTenseCreator
    {
        return new PresentSimpleTenseCreator();
    }

    public function createPresentContinuous(): PresentContinuousTenseCreator
    {
        return new PresentContinuousTenseCreator();
    }

    public function createPresentFuture(): PresentFutureTenseCreator
    {
        return new PresentFutureTenseCreator();
    }
}
