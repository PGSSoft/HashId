<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor\Factory;


use Pgs\HashIdBundle\Tests\AnnotationProvider\ControllerAnnotationMockProvider;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use Pgs\HashIdBundle\Tests\Route\RouteMockProvider;
use PHPUnit\Framework\TestCase;

abstract class ParametersProcessorFactoryTest extends TestCase
{
    protected $controllerMockProvider;

    protected $controllerAnnotationMockProvider;

    protected $routeMockProvider;

    protected function setUp()
    {
        $this->controllerMockProvider = new ControllerMockProvider();
        $this->controllerAnnotationMockProvider = new ControllerAnnotationMockProvider();
        $this->routeMockProvider = new RouteMockProvider();
    }

    public function getControllerMockProvider(): ControllerMockProvider
    {
        return $this->controllerMockProvider;
    }

    public function getControllerAnnotationMockProvider(): ControllerAnnotationMockProvider
    {
        return $this->controllerAnnotationMockProvider;
    }

    public function getRouteMockProvider(): RouteMockProvider
    {
        return $this->routeMockProvider;
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
}