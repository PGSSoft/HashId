<?php


namespace Pgs\HashIdBundle\EventSubscriber;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DecodeParametersSubscriber implements EventSubscriberInterface
{
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController'
        ];
    }
}