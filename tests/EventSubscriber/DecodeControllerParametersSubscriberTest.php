<?php

namespace Pgs\HashIdBundle\Tests\EventSubscriber;

use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;

class DecodeControllerParametersSubscriberTest extends AbstractEventSubscriberTest
{
    public function testSubscribedEvents(): void
    {
        $this->subscribedEventsList(DecodeControllerParametersSubscriber::class);
    }

    public function testOnKernelController(): void
    {
        $subscriber = new DecodeControllerParametersSubscriber($this->getDecodeControllerParametersMock());
        $event = $this->getEvent();
        $encodedParameters = $event->getRequest()->attributes->all();
        $subscriber->onKernelController($event);
        $this->assertNotSame($encodedParameters, $event->getRequest()->attributes->all());
    }

    protected function getDecodeControllerParametersMock(): DecodeControllerParameters
    {
        return $this->createMock(DecodeControllerParameters::class);
    }
}
