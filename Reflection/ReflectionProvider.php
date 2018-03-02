<?php


namespace Pgs\HashIdBundle\Reflection;


use Pgs\HashIdBundle\Exception\MissingClassException;

class ReflectionProvider
{
    public function getMethodReflectionFromClassString(string $class, string $method)
    {
        try {
            $reflectionMethod = new \ReflectionMethod($class, $method);
            return $reflectionMethod;
        } catch (\ReflectionException $e) {
            throw new MissingClassException($e->getMessage(), $e->getCode(), $e);
        }
    }

    public function getMethodReflectionFromObject($object, string $method)
    {
        try {
            $reflectionMethod = new \ReflectionMethod($object, $method);
            return $reflectionMethod;
        } catch (\ReflectionException $e) {
            throw new MissingClassException($e->getMessage(), $e->getCode(), $e);
        }
    }
}