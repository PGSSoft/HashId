<?php


namespace Pgs\HashIdBundle\Service;


use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParameters
{
    protected $parametersProcessorFactory;


    public function __construct(DecodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function decodeControllerParameters(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
        $parametersProcessor = $this->getParametersProcessorFactory()->createControllerDecodeParametersProcessor(...$controller);
        if ($parametersProcessor->needToProcess()) {
            $requestParams = $event->getRequest()->attributes->all();
            $processedParams = $parametersProcessor->process($requestParams);
            $event->getRequest()->attributes->replace($processedParams);
        }
    }

    public function getParametersProcessorFactory(): DecodeParametersProcessorFactory
    {
        return $this->parametersProcessorFactory;
    }
}