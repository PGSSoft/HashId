<?php

namespace Pgs\HashIdBundle\Tests\EventSubscriber;

use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

abstract class AbstractEventSubscriberTest extends TestCase
{
    protected function subscribedEventsList(string $eventSubscriberClass): void
    {
        $this->assertTrue(array_key_exists(KernelEvents::CONTROLLER, $eventSubscriberClass::getSubscribedEvents()));
    }

    protected function getEventMock(): FilterControllerEvent
    {
        $mock = $this->getMockBuilder(FilterControllerEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getRequest'])
            ->getMock();

        $mock->method('getRequest')->willReturn($this->getRequestMock());

        return $mock;
    }

    protected function getRequestMock(): Request
    {
        $mock = $this->getMockBuilder(Request::class)
            ->getMock();
        $parametersBag = $this->getMockBuilder(ParameterBag::class)->setMethods(['all'])->getMock();
        $parametersBag->method('all')->willReturnOnConsecutiveCalls(
            [
                'id' => 'encoded',
                'name' => 'test',
            ],
            [
                'id' => 10,
                'name' => 'test',
            ]
        );
        $mock->attributes = $parametersBag;

        return $mock;
    }
}
