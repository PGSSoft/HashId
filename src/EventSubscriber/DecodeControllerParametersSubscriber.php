<?php

namespace Pgs\HashIdBundle\EventSubscriber;

use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class DecodeControllerParametersSubscriber extends AbstractDecodeControllerParametersSubscriber implements
    DecodeControllerParametersSubscriberInterface
{
    /**
     * @param KernelEvent|ControllerEvent $event
     */
    public function onKernelController(KernelEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
    }

    public function getDecodeControllerParameters(): DecodeControllerParameters
    {
        return $this->decodeControllerParameters;
    }
}
