<?php

namespace Pgs\HashIdBundle\EventSubscriber;

use Symfony\Component\HttpKernel\Event\KernelEvent;

interface DecodeControllerParametersSubscriberInterface
{
    public function onKernelController(KernelEvent $event): void;
}
