<?php

namespace Pgs\HashIdBundle\EventSubscriber\Sf34;

use Pgs\HashIdBundle\EventSubscriber\AbstractDecodeControllerParametersSubscriber;
use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriberInterface;
use Pgs\HashIdBundle\Service\Sf34\DecodeControllerParameters;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\Event\KernelEvent;

class DecodeControllerParametersSubscriber extends AbstractDecodeControllerParametersSubscriber implements
    DecodeControllerParametersSubscriberInterface
{
    /**
     * @param KernelEvent|FilterControllerEvent $event
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
