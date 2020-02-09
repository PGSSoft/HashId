<?php

namespace Pgs\HashIdBundle\EventSubscriber\Sf34;

use Pgs\HashIdBundle\EventSubscriber\AbstractDecodeControllerParametersSubscriber;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParametersSubscriber extends AbstractDecodeControllerParametersSubscriber
{
    public function onKernelController(FilterControllerEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
    }
}
