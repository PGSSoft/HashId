<?php

namespace Pgs\HashIdBundle\Tests\Service;

use Pgs\HashIdBundle\ParametersProcessor\Decode;
use Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use Pgs\HashIdBundle\Tests\Controller\ParamsAnnotatedController;
use Pgs\HashIdBundle\Tests\ParametersProcessor\ParametersProcessorMockProvider;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\ControllerEvent;
use Symfony\Component\HttpKernel\HttpKernelInterface;

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
        $event = $this->getEvent(
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
        $controller = new ParamsAnnotatedController();
        return [
            ['controller' => $controller, 'demo'],
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
        $event = $this->getEvent(
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
    protected function getEvent(array $requestConsecutiveCalls, $controller): ControllerEvent
    {
        $kernel = $this->createMock(HttpKernelInterface::class);
        $request = $this->getRequestMock($requestConsecutiveCalls);

        $event = new ControllerEvent($kernel, $controller, $request, HttpKernelInterface::MAIN_REQUEST);

        return $event;
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
