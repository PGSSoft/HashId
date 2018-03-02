<?php


namespace Pgs\HashIdBundle\ParametersProcessor;


class Decode extends AbstractParametersProcessor
{
    protected function processValue($value)
    {
        $result = $this->getHashIds()->decode($value);
        return $result ? $result[0] : $value;
    }
}