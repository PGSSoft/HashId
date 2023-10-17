<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor\Factory;

use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Exception\MissingClassOrMethodException;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;

class EncodeParametersProcessorFactory extends AbstractParametersProcessorFactory
{
    /**
     * @var ParametersProcessorInterface
     */
    protected $encodeParametersProcessor;

    public function __construct(
        AnnotationProvider $annotationProvider,
        ParametersProcessorInterface $noOpParametersProcessor,
        ParametersProcessorInterface $encodeParametersProcessor
    ) {
        parent::__construct($annotationProvider, $noOpParametersProcessor);
        $this->encodeParametersProcessor = $encodeParametersProcessor;
    }

    public function createRouteEncodeParametersProcessor(string $controller)
    {
        try {
            /** @var Hash $annotation */
            $annotation = $this->getAnnotationProvider()->getFromString($controller, Hash::class);
        } catch (InvalidControllerException | MissingClassOrMethodException $e) {
            $annotation = null;
        }

        return null !== $annotation
            ? $this->getEncodeParametersProcessor()->setParametersToProcess($annotation->getParameters())
            : $this->getNoOpParametersProcessor();
    }

    protected function getEncodeParametersProcessor(): ParametersProcessorInterface
    {
        return $this->encodeParametersProcessor;
    }
}
