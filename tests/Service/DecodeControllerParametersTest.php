<?php

namespace Pgs\HashIdBundle\Tests\Service;

use Pgs\HashIdBundle\ParametersProcessor\Decode;
use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use Pgs\HashIdBundle\Tests\ParametersProcessor\ParametersProcessorMockProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class DecodeControllerParametersTest extends TestCase
{
    protected $controllerMockProvider;

    protected $parametersProcessorMockProvider;

    protected function setUp(): void
    {
        $this->parametersProcessorMockProvider = new ParametersProcessorMockProvider();
    }

    public function getControllerMockProvider(): ControllerMockProvider
    {
        return $this->controllerMockProvider ?? new ControllerMockProvider();
    }

    public function getParametersProcessorMockProvider(): ParametersProcessorMockProvider
    {
        return $this->parametersProcessorMockProvider;
    }

    /**
     * @dataProvider decodeControllerParametersDataProvider
     *
     * @param mixed $controller
     */
    public function testDecodeControllerParameters($controller): void
    {
        $decodeParametersProcessorFactory = $this->getDecodeParametersProcessorFactoryMock();
        $decodeControllerParameters = new DecodeControllerParameters($decodeParametersProcessorFactory);
        $event = $this->getEventMock(
            [
                [
                    'id' => 'encoded',
                    'name' => 'test',
                ],
                [
                    'id' => 10,
                    'name' => 'test',
                ],
            ],
            $controller
        );
        $decodeControllerParameters->decodeControllerParameters($event);
        $this->assertSame(10, $event->getRequest()->attributes->all()['id']);
    }

    public function decodeControllerParametersDataProvider()
    {
        return [
            ['controller as array' => $this->getControllerMockProvider()->getTestControllerMock(), 'demo'],
        ];
    }

    /**
     * @dataProvider decodeControllerParametersDataProvider
     *
     * @param $controller
     */
    public function testDecodeControllerParametersWithParamConverter($controller): void
    {
        $decodeParametersProcessorFactory = $this->getDecodeParametersProcessorFactoryMock();
        $decodeControllerParameters = new DecodeControllerParameters($decodeParametersProcessorFactory);
        $decodeControllerParameters->setParamConverterListener($this->getDoctrineParamConverterListenerMock());
        $event = $this->getEventMock(
            [
                [
                    'id' => 'encoded',
                    'name' => 'test',
                ],
                [
                    'id' => 10,
                    'name' => 'test',
                ],
            ],
            $controller
        );
        $decodeControllerParameters->decodeControllerParameters($event);
        $this->assertSame(10, $event->getRequest()->attributes->all()['id']);
    }

    /**
     * @return DecodeParametersProcessorFactory|MockObject
     */
    protected function getDecodeParametersProcessorFactoryMock(): DecodeParametersProcessorFactory
    {
        $mock = $this->getMockBuilder(DecodeParametersProcessorFactory::class)
            ->disableOriginalConstructor()
            ->setMethods(['createControllerDecodeParametersProcessor'])
            ->getMock();

        $mock->method('createControllerDecodeParametersProcessor')
            ->willReturn($this->getDecodeParametersProcessorMock());

        return $mock;
    }

    protected function getDecodeParametersProcessorMock(): Decode
    {
        $mock = $this->getParametersProcessorMockProvider()->getParametersProcessorMock(Decode::class);
        $mock->method('needToProcess')->willReturn(true);

        return $mock;
    }

    /**
     * @return ControllerEvent|MockObject
     */
    protected function getEventMock(array $requestConsecutiveCalls, $controller): ControllerEvent
    {
        $mock = $this->getMockBuilder(ControllerEvent::class)
            ->disableOriginalConstructor()
            ->setMethods(['getController', 'getRequest'])
            ->getMock();

        $mock->method('getController')
            ->willReturn($controller);

        $mock->method('getRequest')
            ->willReturn($this->getRequestMock($requestConsecutiveCalls));

        return $mock;
    }

    /**
     * @return Request|MockObject
     */
    protected function getRequestMock(array $consecutiveCalls): Request
    {
        $mock = $this->getMockBuilder(Request::class)
            ->getMock();
        $parametersBag = $this->getMockBuilder(ParameterBag::class)->setMethods(['all'])->getMock();
        $parametersBag->method('all')->willReturnOnConsecutiveCalls(...$consecutiveCalls);
        $mock->attributes = $parametersBag;

        return $mock;
    }

    /**
     * @return ParamConverterListener|MockObject
     */
    protected function getDoctrineParamConverterListenerMock(): ParamConverterListener
    {
        $mock = $this->getMockBuilder(ParamConverterListener::class)
            ->disableOriginalConstructor()
            ->setMethods(['onKernelController'])
            ->getMock();

        return $mock;
    }
}
