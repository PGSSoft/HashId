<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor\Factory;


use Pgs\HashIdBundle\Tests\AnnotationProvider\ControllerAnnotationProviderMockProvider;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use Pgs\HashIdBundle\Tests\ParametersProcessor\ParametersProcessorMockProvider;
use Pgs\HashIdBundle\Tests\Route\RouteMockProvider;
use PHPUnit\Framework\TestCase;

abstract class ParametersProcessorFactoryTest extends TestCase
{
    protected $controllerMockProvider;

    protected $controllerAnnotationMockProvider;

    protected $routeMockProvider;

    protected $parametersProcessorMockProvider;

    protected function setUp()
    {
        $this->controllerMockProvider = new ControllerMockProvider();
        $this->controllerAnnotationMockProvider = new ControllerAnnotationProviderMockProvider();
        $this->routeMockProvider = new RouteMockProvider();
        $this->parametersProcessorMockProvider = new ParametersProcessorMockProvider();
    }

    public function getControllerMockProvider(): ControllerMockProvider
    {
        return $this->controllerMockProvider;
    }

    public function getControllerAnnotationMockProvider(): ControllerAnnotationProviderMockProvider
    {
        return $this->controllerAnnotationMockProvider;
    }

    public function getRouteMockProvider(): RouteMockProvider
    {
        return $this->routeMockProvider;
    }

    public function getParametersProcessorMockProvider(): ParametersProcessorMockProvider
    {
        return $this->parametersProcessorMockProvider;
    }
}