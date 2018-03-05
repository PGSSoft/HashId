<?php


namespace Pgs\HashIdBundle\Tests\EventSubscriber;


use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber;
use Pgs\HashIdBundle\ParametersProcessor\Decode;
use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\Tests\AnnotationProvider\ControllerAnnotationProviderMockProvider;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use Pgs\HashIdBundle\Tests\ParametersProcessor\ParametersProcessorMockProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\HttpKernel\KernelEvents;

class DecodeControllerParametersSubscriberTest extends TestCase
{
    protected $controllerMockProvider;

    protected $parametersProcessorMockProvider;

    protected function setUp()
    {
        $this->controllerMockProvider = new ControllerMockProvider();
        $this->parametersProcessorMockProvider = new ParametersProcessorMockProvider();
    }

    public function getControllerMockProvider(): ControllerMockProvider
    {
        return $this->controllerMockProvider;
    }

    public function getParametersProcessorMockProvider(): ParametersProcessorMockProvider
    {
        return $this->parametersProcessorMockProvider;
    }

    public function testDecodeControllerParameters(): void
    {
        $decodeParametersProcessorFactory = $this->getDecodeParametersProcessorFactoryMock();
        $decodeControllerParametersSubscriber = new DecodeControllerParametersSubscriber($decodeParametersProcessorFactory);
        $event = $this->getEventMock();
        $decodeControllerParametersSubscriber->onKernelController($event);
        $this->assertEquals(10, $event->getRequest()->attributes->all()['id']);
    }

    public function testSubscribedEventsList(): void
    {
        $this->assertTrue(array_key_exists(KernelEvents::CONTROLLER, DecodeControllerParametersSubscriber::getSubscribedEvents()));
    }

    protected function getDecodeParametersProcessorFactoryMock(): DecodeParametersProcessorFactory
    {
        $mock = $this->getMockBuilder(DecodeParametersProcessorFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['createControllerDecodeParametersProcessor'])
            ->getMock();

        $mock->method('createControllerDecodeParametersProcessor')->willReturn($this->getDecodeParametersProcessorMock());

        return $mock;
    }

    protected function getDecodeParametersProcessorMock(): Decode
    {
        $mock = $this->getParametersProcessorMockProvider()->getParametersProcessorMock(Decode::class);
        $mock->method('needToProcess')->willReturn(true);

        return $mock;
    }

    protected function getEventMock(): FilterControllerEvent
    {
        $mock = $this->getMockBuilder(FilterControllerEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getController', 'getRequest'])
            ->getMock();

        $mock->method('getController')->willReturn([$this->getControllerMockProvider()->getTestControllerMock(), 'demo']);
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
                'name' => 'test'
            ],
            [
                'id' => 10,
                'name' => 'test'
            ]
        );
        $mock->attributes = $parametersBag;

        return $mock;
    }
}