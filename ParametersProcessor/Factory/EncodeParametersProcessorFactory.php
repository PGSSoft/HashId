<?php


namespace Pgs\HashIdBundle\ParametersProcessor\Factory;


use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use Symfony\Component\Routing\Route;

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
    )
    {
        parent::__construct($annotationProvider, $noOpParametersProcessor);
        $this->encodeParametersProcessor = $encodeParametersProcessor;
    }


    public function createRouteEncodeParametersProcessor(Route $route)
    {
        $controller = $route->getDefault('_controller');
        try{
            /** @var Hash $annotation */
            $annotation = $this->getAnnotationProvider()->getFromString($controller, Hash::class);
        } catch (InvalidControllerException $e){
            $annotation = null;
        }
        return $annotation !== null ? $this->getEncodeParametersProcessor()->setParametersToProcess($annotation->getParameters()) : $this->getNoOpParametersProcessor();
    }

    protected function getEncodeParametersProcessor(): ParametersProcessorInterface
    {
        return $this->encodeParametersProcessor;
    }
}