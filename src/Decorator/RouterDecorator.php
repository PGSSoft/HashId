<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Decorator;

use Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory;
use Pgs\HashIdBundle\Traits\DecoratorTrait;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\CacheWarmer\WarmableInterface;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\RouterInterface;

class RouterDecorator implements RouterInterface, WarmableInterface
{
    use DecoratorTrait;

    protected $parametersProcessorFactory;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        RouterInterface $router,
        EncodeParametersProcessorFactory $parametersProcessorFactory,
        LoggerInterface $logger
    ) {
        $this->object = $router;
        $this->parametersProcessorFactory = $parametersProcessorFactory;
        $this->logger = $logger;
    }

    public function getRouter(): RouterInterface
    {
        return $this->object;
    }

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function generate(
        string $name,
        array $parameters = [],
        int $referenceType = RouterInterface::ABSOLUTE_PATH
    ): string {
        $this->processParameters($this->getRoute($name, $parameters), $parameters);

        return $this->getRouter()->generate($name, $parameters, $referenceType);
    }

    private function getRoute(string $name, array $parameters): ?Route
    {
        $routeCollection = $this->getRouter()->getRouteCollection();
        $route = $routeCollection->get($name);

        if (null === $route) {
            $route = $this->getLocalizedRoute($routeCollection, $name, $parameters);
        } else {
            $this->getLogger()->info(sprintf('Found unlocalized route for "%s" name', $name));
        }

        return $route;
    }

    private function getLocalizedRoute(RouteCollection $routeCollection, string $name, array $parameters): ?Route
    {
        $locale = $parameters['_locale'] ?? $this->getRouter()->getContext()->getParameter('_locale');
        $this->getLogger()->info(
            sprintf('Unlocalized route for "%s" not found, looking for route with "%s" locale', $name, $locale)
        );
        $route = $routeCollection->get(sprintf('%s.%s', $name, $locale));

        if (null !== $route) {
            $this->getLogger()->info(sprintf('Found localized route for "%s" name and "%s" locale', $name, $locale));
        }

        return $route;
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
