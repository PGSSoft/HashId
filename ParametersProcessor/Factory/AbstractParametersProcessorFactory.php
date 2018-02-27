<?php


namespace Pgs\HashIdBundle\ParametersProcessor\Factory;


use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProvider;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;

abstract class AbstractParametersProcessorFactory
{
    /**
     * @var ControllerAnnotationProvider
     */
    protected $annotationProvider;

    /**
     * @var ParametersProcessorInterface
     */
    protected $noOpParametersProcessor;

    public function __construct(
        ControllerAnnotationProvider $annotationProvider,
        ParametersProcessorInterface $noOpParametersProcessor
    )
    {
        $this->annotationProvider = $annotationProvider;
        $this->noOpParametersProcessor = $noOpParametersProcessor;
    }


    protected function getNoOpParametersProcessor(): ParametersProcessorInterface
    {
        return $this->noOpParametersProcessor;
    }

    protected function getAnnotationProvider(): ControllerAnnotationProvider
    {
        return $this->annotationProvider;
    }

}