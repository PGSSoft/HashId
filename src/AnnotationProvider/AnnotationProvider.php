<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\AnnotationProvider;

use Doctrine\Common\Annotations\Reader;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Exception\MissingClassOrMethodException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;

class AnnotationProvider implements AnnotationProviderInterface
{
    /**
     * @var Reader
     */
    protected $reader;

    /**
     * @var ReflectionProvider
     */
    protected $reflectionProvider;

    public function __construct(Reader $reader, ReflectionProvider $reflectionProvider)
    {
        $this->reader = $reader;
        $this->reflectionProvider = $reflectionProvider;
    }

    /**
     * @param string $controller
     * @param string $annotationClassName
     *
     * @throws InvalidControllerException
     * @throws MissingClassOrMethodException
     *
     * @return null|object
     */
    public function getFromString(string $controller, string $annotationClassName)
    {
        $explodedControllerString = explode('::', $controller);
        if (2 !== \count($explodedControllerString)) {
            $message = sprintf('The "%s" controller is not a valid "class::method" string.', $controller);
            throw new InvalidControllerException($message);
        }
        $reflection = $this->reflectionProvider->getMethodReflectionFromClassString(...$explodedControllerString);

        return $this->reader->getMethodAnnotation($reflection, $annotationClassName);
    }

    /**
     * @param object $controller
     * @param string $method
     * @param string $annotationClassName
     *
     * @throws InvalidControllerException
     * @throws MissingClassOrMethodException
     *
     * @return null|object
     */
    public function getFromObject($controller, string $method, string $annotationClassName)
    {
        if (!\is_object($controller)) {
            throw new InvalidControllerException('Provided controller is not an object');
        }
        $reflection = $this->reflectionProvider->getMethodReflectionFromObject($controller, $method);

        return $this->reader->getMethodAnnotation($reflection, $annotationClassName);
    }
}
