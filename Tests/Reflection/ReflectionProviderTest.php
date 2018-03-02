<?php


namespace Pgs\HashIdBundle\Tests\Reflection;


use Pgs\HashIdBundle\Exception\MissingClassOrMethodException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;
use Pgs\HashIdBundle\Tests\Reflection\Fixtures\ExistingClass;
use PHPUnit\Framework\TestCase;

class ReflectionProviderTest extends TestCase
{
    public function testGetProperReflection(): void
    {
        $reflectionProvider = new ReflectionProvider();
        $methodReflection = $reflectionProvider->getMethodReflectionFromClassString(ExistingClass::class, 'existingMethod');
        $this->assertInstanceOf(\ReflectionMethod::class, $methodReflection);
    }

    public function testGetReflectionForNonExistingClass(): void
    {
        $this->expectException(MissingClassOrMethodException::class);
        $reflectionProvider = new ReflectionProvider();
        $reflectionProvider->getMethodReflectionFromClassString('NonExistingClass', 'nonExistingMethod');
    }

    public function testGetMethodReflectionFromObject(): void
    {
        $reflectionProvider = new ReflectionProvider();
        $methodReflection = $reflectionProvider->getMethodReflectionFromObject(new ExistingClass(), 'existingMethod');
        $this->assertInstanceOf(\ReflectionMethod::class, $methodReflection);
    }

    public function testGetMethodReflectionForNonExistingMethodFromObject(): void
    {
        $this->expectException(MissingClassOrMethodException::class);
        $reflectionProvider = new ReflectionProvider();
        $methodReflection = $reflectionProvider->getMethodReflectionFromObject(new ExistingClass(), 'nonExistingMethod');
        $this->assertInstanceOf(\ReflectionMethod::class, $methodReflection);
    }

}
