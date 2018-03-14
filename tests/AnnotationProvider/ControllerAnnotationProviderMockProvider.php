<?php

namespace Pgs\HashIdBundle\Tests\AnnotationProvider;

use Pgs\HashIdBundle\Annotation\Hash;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Tests\Controller\ControllerMockProvider;
use PHPUnit\Framework\TestCase;

class ControllerAnnotationProviderMockProvider extends TestCase
{
    protected $controllerMockProvider;

    public function __construct()
    {
        $this->controllerMockProvider = new ControllerMockProvider();
    }

    public function getControllerMockProvider(): ControllerMockProvider
    {
        return $this->controllerMockProvider;
    }

    public function getExistingControllerAnnotationProviderMock(): AnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')->with('TestController::testMethod', Hash::class)->willReturn(new Hash([]));
        $mock->method('getFromObject')->with(
            $this->getControllerMockProvider()->getTestControllerMock(),
            'testMethod',
            Hash::class
        )->willReturn(new Hash([]));

        return $mock;
    }

    public function getInvalidControllerExceptionControllerAnnotationProviderMock(): AnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromObject')
            ->with('test_controller_string', 'testMethod', Hash::class)
            ->willThrowException(new InvalidControllerException());

        return $mock;
    }

    public function getNotExistingControllerAnnotationProviderMock(): AnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')
            ->with('TestController::testMethod', Hash::class)->willReturn(null);

        return $mock;
    }

    public function getExceptionThrowControllerAnnotationProviderMock(): AnnotationProvider
    {
        $mock = $this->getControllerAnnotationProviderMock();
        $mock->method('getFromString')
            ->with('bad_controller_string', Hash::class)
            ->willThrowException(new InvalidControllerException());

        return $mock;
    }

    private function getControllerAnnotationProviderMock()
    {
        return $this->getMockBuilder(AnnotationProvider::class)
            ->disableOriginalConstructor()
            ->setMethods(['getFromString', 'getFromObject'])
            ->getMock();
    }
}
