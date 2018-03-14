<?php

namespace Pgs\HashIdBundle\Service;

use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParameters
{
    protected $parametersProcessorFactory;

    protected $paramConverterListener;

    public function __construct(DecodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function decodeControllerParameters(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
        $parametersProcessor = $this
            ->getParametersProcessorFactory()
            ->createControllerDecodeParametersProcessor(...$controller);

        $this->processRequestParameters($event, $parametersProcessor);
        $this->processRequestParametersWithParamConverter($event);
    }

    protected function processRequestParameters(
        FilterControllerEvent $event,
        ParametersProcessorInterface $parametersProcessor
    ): void {
        if ($parametersProcessor->needToProcess()) {
            $requestParams = $event->getRequest()->attributes->all();
            $processedParams = $parametersProcessor->process($requestParams);
            $event->getRequest()->attributes->replace($processedParams);
        }
    }

    protected function processRequestParametersWithParamConverter(FilterControllerEvent $event): void
    {
        if (null !== $this->getParamConverterListener()) {
            $this->getParamConverterListener()->onKernelController($event);
        }
    }

    public function getParametersProcessorFactory(): DecodeParametersProcessorFactory
    {
        return $this->parametersProcessorFactory;
    }

    public function getParamConverterListener(): ?ParamConverterListener
    {
        return $this->paramConverterListener;
    }

    public function setParamConverterListener(ParamConverterListener $paramConverterListener): void
    {
        $this->paramConverterListener = $paramConverterListener;
    }
}
