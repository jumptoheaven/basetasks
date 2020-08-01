<?php

namespace App\TenseVerbCreator;

class TransformerFactory
{

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
