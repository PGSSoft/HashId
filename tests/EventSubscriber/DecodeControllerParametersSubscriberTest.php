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
        $subscriber = new DecodeControllerParametersSubscriber($this->createMock(DecodeControllerParameters::class));
        $event = $this->getEventMock();
        $encodedParameters = $event->getRequest()->attributes->all();
        $subscriber->onKernelController($event);
        $this->assertNotEquals($encodedParameters, $event->getRequest()->attributes->all());
    }
}