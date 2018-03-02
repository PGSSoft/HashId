<?php


namespace Pgs\HashIdBundle\AnnotationProvider;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

interface ControllerAnnotationProviderInterface
{
    public function getFromString(string $controller, string $annotationClassName);
    public function getFromObject(Controller $controller, string $method, string $annotationClassName);
}