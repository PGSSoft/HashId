<?php


namespace Pgs\HashIdBundle\AnnotationProvider;


use Doctrine\Common\Annotations\Reader;
use Pgs\HashIdBundle\Exception\InvalidControllerException;
use Pgs\HashIdBundle\Reflection\ReflectionProvider;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControllerAnnotationProvider implements ControllerAnnotationProviderInterface
{
    /**
     * @var Reader
     */
    protected $reader;

    protected $reflectionProvider;

    public function __construct(Reader $reader, ReflectionProvider $reflectionProvider)
    {
        $this->reader = $reader;
        $this->reflectionProvider = $reflectionProvider;
    }

    public function getFromString(string $controller, string $annotationClassName)
    {
        $explodedControllerString = explode('::', $controller);
        if (count($explodedControllerString) !== 2) {
            throw new InvalidControllerException(sprintf('The "%s" controller is not a valid "class::method" string.', $controller));
        }
        $reflection = $this->reflectionProvider->getMethodReflectionFromClassString(...$explodedControllerString);

        return $this->reader->getMethodAnnotation($reflection, $annotationClassName);
    }

    public function getFromObject(Controller $controller, string $method, string $annotationClassName)
    {
        $reflection = $this->reflectionProvider->getMethodReflectionFromObject($controller, $method);
        return $this->reader->getMethodAnnotation($reflection, $annotationClassName);
    }
}