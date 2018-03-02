<?php


namespace Pgs\HashIdBundle\ParametersProcessor\Factory;


use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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

    public function createControllerDecodeParametersProcessor(Controller $controller, string $method)
    {
        /** @var Hash $annotation */
        $annotation = $this->getAnnotationProvider()->getFromObject($controller, $method, Hash::class);
        return $annotation !== null ? $this->getDecodeParametersProcessor()->setParametersToProcess($annotation->getParameters()) : $this->getNoOpParametersProcessor();
    }
}