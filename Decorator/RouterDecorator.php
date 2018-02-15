<?php


namespace Pgs\HashIdBundle\Decorator;


use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class RouterDecorator implements RouterInterface
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
        if (isset($parameters['id'])) {
            $parameters['id'] .= '_HASHED__zzz-zzz';
        }
        $route = $this->getRouter()->getRouteCollection()->get($name);
        $controller = $route->getDefault('_controller');

        // @var $allOptions will have all the options for current route.
        $allOptions = $route->getOptions();
        return $this->getRouter()->generate($name, $parameters, $referenceType);
    }

    public function setContext(RequestContext $context)
    {
        $this->getRouter()->setContext($context);
    }

    public function getContext()
    {
        return $this->getRouter()->getContext();
    }

    public function getRouteCollection()
    {
        return $this->getRouter()->getRouteCollection();
    }

    public function match($pathinfo)
    {
        return $this->getRouter()->match($pathinfo);
    }


}