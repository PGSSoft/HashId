<?php


namespace Pgs\HashIdBundle\EventSubscriber;


use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DecodeControllerParametersSubscriber implements EventSubscriberInterface
{
    protected $decodeControllerParameters;

    public function __construct(DecodeControllerParameters $decodeControllerParameters)
    {
        $this->decodeControllerParameters = $decodeControllerParameters;
    }

    public function onKernelController(FilterControllerEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }

    public function getDecodeControllerParameters(): DecodeControllerParameters
    {
        return $this->decodeControllerParameters;
    }
}