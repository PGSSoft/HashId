<?php


namespace Pgs\HashIdBundle\Reflection;


use Pgs\HashIdBundle\Exception\MissingClassOrMethodException;

class ReflectionProvider
{
    public function getMethodReflectionFromClassString(string $class, string $method): ?\ReflectionMethod
    {
        try {
            return new \ReflectionMethod($class, $method);
        } catch (\ReflectionException $e) {
            throw new MissingClassOrMethodException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getMethodReflectionFromObject($object, string $method): ?\ReflectionMethod
    {
        try {
            return new \ReflectionMethod($object, $method);
        } catch (\ReflectionException $e) {
            throw new MissingClassOrMethodException($e->getMessage(), $e->getCode(), $e);
        }
    }
}