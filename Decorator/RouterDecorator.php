<?php


namespace Pgs\HashIdBundle\Decorator;


use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorFactory;
use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\RouterInterface;

class RouterDecorator implements RouterInterface
{
    use DecoratorTrait;

    protected $parametersProcessorFactory;

    public function __construct(RouterInterface $router, ParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->object = $router;
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function getRouter(): RouterInterface
    {
        return $this->object;
    }

    public function generate($name, $parameters = array(), $referenceType = RouterInterface::ABSOLUTE_PATH)
    {
        $route = $this->getRouter()->getRouteCollection()->get($name);
        $parametersProcessor = $this->parametersProcessorFactory->createRouteEncodeParametersProcessor($route);

        $parameters = $parametersProcessor->process($parameters);

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