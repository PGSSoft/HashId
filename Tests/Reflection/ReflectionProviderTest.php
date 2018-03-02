<?php


namespace Pgs\HashIdBundle\Tests\Reflection;


use Pgs\HashIdBundle\Exception\MissingClassException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;
use Pgs\HashIdBundle\Tests\Reflection\Fixtures\ExistingClass;
use PHPUnit\Framework\TestCase;

class ReflectionProviderTest extends TestCase
{
    public function testGetProperReflection()
    {
        $reflectionProvider = new ReflectionProvider();
        $methodReflection = $reflectionProvider->getMethodReflectionFromClassString(ExistingClass::class, 'existingMethod');
        $this->assertInstanceOf(\ReflectionMethod::class, $methodReflection);
    }

    protected function getExistingMethodReflection()
    {

    }

    public function testGetReflectionForNonExistingClass(){
        $this->expectException(MissingClassException::class);
        $reflectionProvider = new ReflectionProvider();
        $methodReflection = $reflectionProvider->getMethodReflectionFromClassString('NonExistingClass', 'nonExistingMethod');
    }
}