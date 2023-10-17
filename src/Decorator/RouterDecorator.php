<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Decorator;

use Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory;
use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\Exception\MethodNotAllowedException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Symfony\Component\Routing\RequestContext;
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
        $this->processParameters($this->getRoute($name, $parameters), $parameters);

        return $this->getRouter()->generate($name, $parameters, $referenceType);
    }

    private function getRoute(string $name, array $parameters): ?array
    {
        $url = null;

        try {
            $url = $this->getRouter()->generate($name, $parameters);
        } catch (RouteNotFoundException $e) {
            $locale = $parameters['_locale'] ?? $this->getRouter()->getContext()->getParameter('_locale');
            $url = $this->getRouter()->generate(sprintf('%s.%s', $name, $locale));
        }

        try {
            return $this->getRouter()->match($url);
        } catch (\Exception $e) {
            // Ignore method not allow, no route found, etc.
        }

        return null;
    }

    private function processParameters(?array $route, array &$parameters): void
    {
        if (null !== $route) {
            $parametersProcessor = $this->parametersProcessorFactory->createRouteEncodeParametersProcessor($route['_controller']);
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
