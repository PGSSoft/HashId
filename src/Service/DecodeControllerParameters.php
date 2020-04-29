<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Service;

use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class DecodeControllerParameters
{
    protected $parametersProcessorFactory;

    protected $paramConverterListener;

    public function __construct(DecodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function decodeControllerParameters(ControllerEvent $event): void
    {
        $controller = $event->getController();
        if (is_array($controller)){
            list($controllerObject, $method) = $controller;
        } elseif (is_object($controller) && !$controller instanceof \Closure){
            $controllerObject = $controller;
            $method = '__invoke';
        } else {
            //Controller is a closure
            return;
        }

        $parametersProcessor = $this
            ->getParametersProcessorFactory()
            ->createControllerDecodeParametersProcessor($controllerObject, $method);

        $this->processRequestParameters($event, $parametersProcessor);
        $this->processRequestParametersWithParamConverter($event);
    }

    protected function processRequestParameters(
        ControllerEvent $event,
        ParametersProcessorInterface $parametersProcessor
    ): void {
        if ($parametersProcessor->needToProcess()) {
            $requestParams = $event->getRequest()->attributes->all();
            $processedParams = $parametersProcessor->process($requestParams);
            $event->getRequest()->attributes->replace($processedParams);
        }
    }

    protected function processRequestParametersWithParamConverter(ControllerEvent $event): void
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
