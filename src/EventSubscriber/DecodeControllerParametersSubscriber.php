<?php

namespace Pgs\HashIdBundle\EventSubscriber;

use Symfony\Component\HttpKernel\Event\ControllerEvent;

class DecodeControllerParametersSubscriber extends AbstractDecodeControllerParametersSubscriber
{
    public function onKernelController(ControllerEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
    }
}
