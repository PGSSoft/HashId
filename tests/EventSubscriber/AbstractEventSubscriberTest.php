<?php

namespace Pgs\HashIdBundle\Tests\EventSubscriber;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;
use Symfony\Component\HttpKernel\KernelEvents;

abstract class AbstractEventSubscriberTest extends TestCase
{
    protected function subscribedEventsList(string $eventSubscriberClass): void
    {
        $this->assertTrue(\array_key_exists(KernelEvents::CONTROLLER, $eventSubscriberClass::getSubscribedEvents()));
    }

    /**
     * @return ControllerEvent
     */
    protected function getEvent(): ControllerEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->getRequestMock();
        $event = new ControllerEvent($kernel, fn() => (null), $request, HttpKernelInterface::MAIN_REQUEST);

        return $event;
    }

    /**
     * @return Request|MockObject
     */
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
