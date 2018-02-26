<?php


namespace Pgs\HashIdBundle\ParametersProcessor;


use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProvider;
use Symfony\Component\Routing\Route;

class ParametersProcessorFactory
{
    /**
     * @var ParametersProcessorInterface
     */
    protected $encodeParametersProcessor;

    /**
     * @var ParametersProcessorInterface
     */
    protected $decodeParametersProcessor;

    /**
     * @var ParametersProcessorInterface
     */
    protected $noOpParametersProcessor;

    /**
     * @var ControllerAnnotationProvider
     */
    protected $annotationProvider;

    /**
     * @param ParametersProcessorInterface $encodeParametersProcessor
     * @param ParametersProcessorInterface $decodeParametersProcessor
     * @param ParametersProcessorInterface $noOpParametersProcessor
     * @param ControllerAnnotationProvider $annotationProvider
     */
    public function __construct(
        ParametersProcessorInterface $encodeParametersProcessor,
        ParametersProcessorInterface $decodeParametersProcessor,
        ParametersProcessorInterface $noOpParametersProcessor,
        ControllerAnnotationProvider $annotationProvider)
    {
        $this->encodeParametersProcessor = $encodeParametersProcessor;
        $this->decodeParametersProcessor = $decodeParametersProcessor;
        $this->noOpParametersProcessor = $noOpParametersProcessor;
        $this->annotationProvider = $annotationProvider;
    }


    public function createRouteEncodeParametersProcessor(Route $route)
    {
        $controller = $route->getDefault('_controller');
        /** @var Hash $annotation */
        $annotation = $this->annotationProvider->get($controller, Hash::class);
        return $annotation !== null ? $this->encodeParametersProcessor->setParametersToProcess($annotation->getParameters()) : new NoOp();
    }
}