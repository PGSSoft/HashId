<?php


namespace Pgs\HashIdBundle\EventSubscriber;


use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DecodeParametersSubscriber implements EventSubscriberInterface
{
    protected $parametersProcessorFactory;

    public function __construct(DecodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();
        $parametersProcessor = $this->parametersProcessorFactory->createControllerDecodeParametersProcessor(...$controller);
        if ($parametersProcessor->needToProcess()) {
            $requestParams = $event->getRequest()->attributes->all();
            $processedParams = $parametersProcessor->process($requestParams);
            $event->getRequest()->attributes->replace($processedParams);
        }
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }

    public function getParametersProcessorFactory(): DecodeParametersProcessorFactory
    {
        return $this->parametersProcessorFactory;
    }


}