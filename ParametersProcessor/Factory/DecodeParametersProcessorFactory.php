<?php


namespace Pgs\HashIdBundle\ParametersProcessor\Factory;


use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;

class DecodeParametersProcessorFactory extends AbstractParametersProcessorFactory
{
    /**
     * @var ParametersProcessorInterface
     */
    protected $decodeParametersProcessor;

    protected function getDecodeParametersProcessor(): ParametersProcessorInterface
    {
        return $this->decodeParametersProcessor;
    }
}