<?php


namespace Pgs\HashIdBundle\AnnotationProvider;


interface ControllerAnnotationProviderInterface
{
    public function get(string $controller, string $annotationClassName);
}