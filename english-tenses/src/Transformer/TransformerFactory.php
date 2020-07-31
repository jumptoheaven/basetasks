<?php

namespace App\Transformer;

class TransformerFactory
{

    public function createPresentSimple(): PresentSimpleTransformer
    {
        return new PresentSimpleTransformer();
    }

    public function createPresentContinuous(): PresentContinuousTransformer
    {
        return new PresentContinuousTransformer();
    }
}
