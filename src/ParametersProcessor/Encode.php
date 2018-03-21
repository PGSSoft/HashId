<?php

namespace Pgs\HashIdBundle\ParametersProcessor;

class Encode extends AbstractParametersProcessor
{
    protected function processValue($value): string
    {
        return $this->getHashIds()->encode($value);
    }
}
