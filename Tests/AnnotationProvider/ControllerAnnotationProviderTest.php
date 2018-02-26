<?php


namespace Pgs\HashIdBundle\Tests\AnnotationProvider;

use Doctrine\Common\Annotations\Reader;
use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProvider;
use Pgs\HashIdBundle\AnnotationProvider\ControllerAnnotationProviderInterface;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;
use PHPUnit\Framework\TestCase;

class ControllerAnnotationProviderTest extends TestCase
{
    /**
     * @var ControllerAnnotationProviderInterface
     */
    protected $controllerAnnotationProvider;

    protected function setUp()
    {
        $this->controllerAnnotationProvider = new ControllerAnnotationProvider($this->getReaderMock(), $this->getReflectionProviderMock());
    }

    public function testCreate()
    {
        $this->assertInstanceOf(ControllerAnnotationProvider::class, $this->controllerAnnotationProvider);
    }

    public function testInvalidControllerString()
    {
        $this->expectException(InvalidControllerException::class);
        $this->controllerAnnotationProvider->get('dummy_controler_string', 'annotationClassName');
    }

    public function testReturnObject()
    {
        $result = $this->controllerAnnotationProvider->get('\Pgs\HashIdBundle\Controller\DemoController::demo', 'annotationClassName');
        $this->assertEquals(true, is_object($result));
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
            ->setMethods(['getMethodReflection'])
            ->getMock();
        $reflectionProviderMock
            ->method('getMethodReflection')
            ->with('\Pgs\HashIdBundle\Controller\DemoController','demo')->willReturn($this->createMock(\ReflectionMethod::class));

        return $reflectionProviderMock;
    }
}