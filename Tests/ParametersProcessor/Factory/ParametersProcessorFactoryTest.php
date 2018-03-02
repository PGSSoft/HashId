<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor\Factory;


use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProvider;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Route;

abstract class ParametersProcessorFactoryTest extends TestCase
{
    protected function getExistingControllerAnnotationProviderMock(): ControllerAnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')->with('TestController::testMethod', Hash::class)->willReturn(new Hash([]));
        $mock->method('getFromObject')->with($this->getTestControllerMock(), 'testMethod', Hash::class)->willReturn(new Hash([]));

        return $mock;
    }

    protected function getNotExistingControllerAnnotationProviderMock(): ControllerAnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')
            ->with('TestController::testMethod', Hash::class)->willReturn(null);

        return $mock;
    }

    protected function getExceptionThrowControllerAnnotationProviderMock(): ControllerAnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')->with('bad_controller_string', Hash::class)->willThrowException(new InvalidControllerException());

        return $mock;
    }

    protected function getParametersProcessorMock($class)
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
            ->setMethods(['getFromString', 'getFromObject'])
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

    protected function getInvalidRouteMock()
    {
        $mock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDefault'])
            ->getMock();
        $mock->method('getDefault')->with('_controller')->willReturn('bad_controller_string');

        return $mock;
    }

    protected function getTestControllerMock(): Controller
    {
        return $this->getMockBuilder(Controller::class)
            ->getMockForAbstractClass();
    }

}