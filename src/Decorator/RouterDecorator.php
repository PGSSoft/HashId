<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Decorator;

use Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory;
use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouterInterface;

class RouterDecorator implements RouterInterface, WarmableInterface
{
    use DecoratorTrait;

    protected $parametersProcessorFactory;

    public function __construct(RouterInterface $router, EncodeParametersProcessorFactory $parametersProcessorFactory)
    {
        $this->object = $router;
        $this->parametersProcessorFactory = $parametersProcessorFactory;
    }

    public function getRouter(): RouterInterface
    {
        return $this->object;
    }

    public function generate(
        string $name,
        array $parameters = [],
        int $referenceType = RouterInterface::ABSOLUTE_PATH
    ): string {
        $route = $this->getRouter()->getRouteCollection()->get($name);
        $this->processParameters($route, $parameters);

        return $this->getRouter()->generate($name, $parameters, $referenceType);
    }

    private function processParameters(?Route $route, array &$parameters): void
    {
        if (null !== $route) {
            $parametersProcessor = $this->parametersProcessorFactory->createRouteEncodeParametersProcessor($route);
            if ($parametersProcessor->needToProcess()) {
                $parameters = $parametersProcessor->process($parameters);
            }
        }
    }

    /**
     * @codeCoverageIgnore
     */
    public function setContext(RequestContext $context)
    {
        $this->getRouter()->setContext($context);
    }

    /**
     * @codeCoverageIgnore
     */
    public function getContext()
    {
        return $this->getRouter()->getContext();
    }

    /**
     * @codeCoverageIgnore
     */
    public function getRouteCollection()
    {
        return $this->getRouter()->getRouteCollection();
    }

    /**
     * @codeCoverageIgnore
     */
    public function match(string $pathinfo)
    {
        return $this->getRouter()->match($pathinfo);
    }

    /**
     * @codeCoverageIgnore
     */
    public function warmUp($cacheDir)
    {
        if ($this->getRouter() instanceof WarmableInterface) {
            $this->getRouter()->warmUp($cacheDir);
        }
    }
}
