<?php

namespace Pgs\HashIdBundle\Service;

use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpKernel\Event\KernelEvent;

abstract class AbstractDecodeControllerParameters
{

    protected $parametersProcessorFactory;
    protected $paramConverterListener;

    public function __construct(DecodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function getParamConverterListener(): ?ParamConverterListener
    {
        return $this->paramConverterListener;
    }

    public function getParametersProcessorFactory(): DecodeParametersProcessorFactory
    {
        return $this->parametersProcessorFactory;
    }

    public function setParamConverterListener(ParamConverterListener $paramConverterListener): void
    {
        $this->paramConverterListener = $paramConverterListener;
    }

    protected function processRequestParametersWithParamConverter(KernelEvent $event): void
    {
        if (null !== $this->getParamConverterListener()) {
            $this->getParamConverterListener()->onKernelController($event);
        }
    }

    protected function processRequestParameters(
        KernelEvent $event,
        ParametersProcessorInterface $parametersProcessor
    ): void {
        if ($parametersProcessor->needToProcess()) {
            $requestParams = $event->getRequest()->attributes->all();
            $processedParams = $parametersProcessor->process($requestParams);
            $event->getRequest()->attributes->replace($processedParams);
        }
    }
}