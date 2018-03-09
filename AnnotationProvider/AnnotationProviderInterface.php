<?php


namespace Pgs\HashIdBundle\AnnotationProvider;


interface AnnotationProviderInterface
{
    public function getFromString(string $controller, string $annotationClassName);

    public function getFromObject($controller, string $method, string $annotationClassName);
}