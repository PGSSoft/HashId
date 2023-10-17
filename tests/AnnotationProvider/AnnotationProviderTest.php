<?php

namespace Pgs\HashIdBundle\Tests\AnnotationProvider;

use Doctrine\Common\Annotations\Reader;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\AnnotationProvider\AnnotationProviderInterface;
use Pgs\HashIdBundle\Controller\DemoController;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;
use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AnnotationProviderTest extends TestCase
{
    /**
     * @var AnnotationProviderInterface
     */
    protected $controllerAnnotationProvider;

    protected function setUp(): void
    {
        $this->controllerAnnotationProvider = new AnnotationProvider(
            $this->getReaderMock(),
            $this->getReflectionProviderMock()
        );
    }

    public function testCreate(): void
    {
        $this->assertInstanceOf(AnnotationProvider::class, $this->controllerAnnotationProvider);
    }

    public function testInvalidControllerString(): void
    {
        $this->expectException(InvalidControllerException::class);
        $this->controllerAnnotationProvider->getFromString('dummy_controler_string', 'annotationClassName');
    }

    public function testReturnObject(): void
    {
        $result = $this->controllerAnnotationProvider->getFromString(
            'Pgs\HashIdBundle\Controller\DemoController::demo',
            'annotationClassName'
        );
        $this->assertTrue(\is_object($result));

        $controller = $this->getControllerMock();
        $result = $this->controllerAnnotationProvider->getFromObject($controller, 'demo', 'annotationClassName');
        $this->assertTrue(\is_object($result));
    }

    public function testInvalidControllerObject(): void
    {
        $this->expectException(InvalidControllerException::class);
        $controller = 'dummy_controller_string';
        $this->controllerAnnotationProvider->getFromObject($controller, 'demo', 'annotationClassName');
    }

    protected function getReaderMock()
    {
        $readerMock = $this->getMockBuilder(Reader::class)
            ->setMethods(['getMethodAnnotation'])
            ->getMockForAbstractClass();
        $readerMock
            ->method('getMethodAnnotation')
            ->with($this->createMock(\ReflectionMethod::class))->willReturn(new \stdClass());

        return $readerMock;
    }

    protected function getReflectionProviderMock()
    {
        $reflectionProviderMock = $this->getMockBuilder(ReflectionProvider::class)
            ->setMethods([
                'getMethodReflectionFromClassString',
                'getMethodReflectionFromObject',
            ])
            ->getMock();
        $reflectionProviderMock
            ->method('getMethodReflectionFromClassString')
            ->with(DemoController::class, 'demo')->willReturn($this->createMock(\ReflectionMethod::class));

        $reflectionProviderMock
            ->method('getMethodReflectionFromObject')
            ->with($this->getControllerMock(), 'demo')->willReturn($this->createMock(\ReflectionMethod::class));

        return $reflectionProviderMock;
    }

    protected function getControllerMock()
    {
        $mock = $this->getMockBuilder(Controller::class)->setMethods(['demo'])->getMockForAbstractClass();

        return $mock;
    }
}
