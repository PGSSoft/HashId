<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor;


use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProvider;
use Pgs\HashIdBundle\ParametersProcessor\Decode;
use Pgs\HashIdBundle\ParametersProcessor\Encode;
use Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory;
use Pgs\HashIdBundle\ParametersProcessor\NoOp;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;

class ParametersProcessorFactoryTest extends TestCase
{
    protected $parametersProcessorFactory;

    public function testCreateRouteEncodeParametersProcessor()
    {
        $encodeParametersProcessor = $this->getParametersProcessorMock(Encode::class);
        $noOpParametersProcessor = $this->getParametersProcessorMock(NoOp::class);
        $parametersProcessorFactory = new EncodeParametersProcessorFactory(
            $this->getExistingControllerAnnotationProviderMock(),
            $noOpParametersProcessor,
            $encodeParametersProcessor
        );

        $parametersProcessor = $parametersProcessorFactory->createRouteEncodeParametersProcessor($this->getTestRouteMock());
        $this->assertInstanceOf(get_class($encodeParametersProcessor), $parametersProcessor);
    }

    public function testCreateRouteNoOpParametersProcessor()
    {
        $encodeParametersProcessor = $this->getParametersProcessorMock(Encode::class);
        $noOpParametersProcessor = $this->getParametersProcessorMock(NoOp::class);
        $parametersProcessorFactory = new EncodeParametersProcessorFactory(
            $this->getNotExistingControllerAnnotationProviderMock(),
            $noOpParametersProcessor,
            $encodeParametersProcessor
        );

        $parametersProcessor = $parametersProcessorFactory->createRouteEncodeParametersProcessor($this->getTestRouteMock());
        $this->assertInstanceOf(get_class($noOpParametersProcessor), $parametersProcessor);
    }

    protected function getExistingControllerAnnotationProviderMock(): ControllerAnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('get')->with('TestController::testMethod', Hash::class)->willReturn(new Hash([]));

        return $mock;
    }

    protected function getNotExistingControllerAnnotationProviderMock(): ControllerAnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('get')->with('TestController::testMethod', Hash::class)->willReturn(null);

        return $mock;
    }

    private function getParametersProcessorMock($class)
    {
        $mock = $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods(['setParametersToProcess'])
            ->getMock();

        $mock->method('setParametersToProcess')->willReturnSelf();

        return $mock;
    }

    private function getControllerAnnotationProviderMock()
    {

        return $this->getMockBuilder(ControllerAnnotationProvider::class)
            ->disableOriginalConstructor()
            ->setMethods(['get'])
            ->getMock();
    }

    protected function getTestRouteMock()
    {
        $mock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDefault'])
            ->getMock();
        $mock->method('getDefault')->with('_controller')->willReturn('TestController::testMethod');

        return $mock;
    }

}