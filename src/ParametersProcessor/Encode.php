<?php


namespace Pgs\HashIdBundle\ParametersProcessor;


class Encode extends AbstractParametersProcessor
{
    protected function processValue($value)
    {
        return $this->getHashIds()->encode($value);
    }
}