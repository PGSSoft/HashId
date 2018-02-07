<?php


namespace Pgs\HashIdBundle\Decorator;


use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Symfony\Component\Routing\RouterInterface;

class RouterDecorator
{
    use DecoratorTrait;

    public function __construct(RouterInterface $router)
    {
        $this->object = $router;
    }

    public function getRouter(): RouterInterface
    {
        return $this->object;
    }

    public function generate($name, $parameters = array(), $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        if (isset($parameters['id'])){
            $parameters['id'] .= '_HASHED__';
        }
        $route = $this->getRouter()->getRouteCollection()->get($name);

        // @var $allOptions will have all the options for current route.
        $allOptions = $route->getOptions();
        return $this->getRouter()->generate($name, $parameters, $referenceType);
    }


}