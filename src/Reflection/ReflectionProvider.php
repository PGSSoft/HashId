<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Reflection;

use Pgs\HashIdBundle\Exception\MissingClassOrMethodException;

class ReflectionProvider
{
    /**
     * @param string $class
     * @param string $method
     *
     * @throws MissingClassOrMethodException
     *
     * @return null|\ReflectionMethod
     */
    public function getMethodReflectionFromClassString(string $class, string $method): ?\ReflectionMethod
    {
        try {
            return new \ReflectionMethod($class, $method);
        } catch (\ReflectionException $e) {
            throw new MissingClassOrMethodException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @param object $object
     * @param string $method
     *
     * @throws MissingClassOrMethodException
     *
     * @return null|\ReflectionMethod
     */
    public function getMethodReflectionFromObject($object, string $method): ?\ReflectionMethod
    {
        try {
            return new \ReflectionMethod($object, $method);
        } catch (\ReflectionException $e) {
            throw new MissingClassOrMethodException($e->getMessage(), $e->getCode(), $e);
        }
    }
}
