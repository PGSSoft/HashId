<?php

namespace Pgs\HashIdBundle\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;

abstract class AbstractDecodeControllerParametersSubscriber implements
    EventSubscriberInterface,
    DecodeControllerParametersSubscriberInterface
{
    protected $decodeControllerParameters;

    public function __construct(DecodeControllerParametersSubscriberInterface $decodeControllerParameters)
    {
        $this->decodeControllerParameters = $decodeControllerParameters;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}
