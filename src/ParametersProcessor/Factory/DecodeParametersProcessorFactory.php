<?php

namespace Pgs\HashIdBundle\ParametersProcessor\Factory;

use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;

class DecodeParametersProcessorFactory extends AbstractParametersProcessorFactory
{
    /**
     * @var ParametersProcessorInterface
     */
    protected $decodeParametersProcessor;

    public function __construct(
        AnnotationProvider $annotationProvider,
        ParametersProcessorInterface $noOpParametersProcessor,
        ParametersProcessorInterface $decodeParametersProcessor
    ) {
        parent::__construct($annotationProvider, $noOpParametersProcessor);
        $this->decodeParametersProcessor = $decodeParametersProcessor;
    }

    protected function getDecodeParametersProcessor(): ParametersProcessorInterface
    {
        return $this->decodeParametersProcessor;
    }

    public function createControllerDecodeParametersProcessor($controller, string $method)
    {
        try {
            /** @var Hash $annotation */
            $annotation = $this->getAnnotationProvider()->getFromObject($controller, $method, Hash::class);
        } catch (InvalidControllerException $e) {
            $annotation = null;
        }

        return null !== $annotation ? $this->getDecodeParametersProcessor()->setParametersToProcess($annotation->getParameters()) : $this->getNoOpParametersProcessor();
    }
}
