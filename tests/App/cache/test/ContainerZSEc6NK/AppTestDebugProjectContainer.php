<?php

namespace ContainerZSEc6NK;

use Symfony\Component\DependencyInjection\Argument\RewindableGenerator;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\LogicException;
use Symfony\Component\DependencyInjection\Exception\RuntimeException;
use Symfony\Component\DependencyInjection\ParameterBag\FrozenParameterBag;

/**
 * This class has been auto-generated
 * by the Symfony Dependency Injection Component.
 *
 * @final since Symfony 3.3
 */
class AppTestDebugProjectContainer extends Container
{
    private $buildParameters;
    private $parameters;
    private $targetDirs = array();

    /**
     * @internal but protected for BC on cache:clear
     */
    protected $privates = array();

    public function __construct(array $buildParameters = array())
    {
        $dir = $this->targetDirs[0] = \dirname(__DIR__);
        for ($i = 1; $i <= 5; ++$i) {
            $this->targetDirs[$i] = $dir = \dirname($dir);
        }
        $this->buildParameters = $buildParameters;
        $this->parameters = $this->getDefaultParameters();

        $this->services = $this->privates = array();
        $this->syntheticIds = array(
            'kernel' => true,
        );
        $this->methodMap = array(
            'event_dispatcher' => 'getEventDispatcherService',
            'http_kernel' => 'getHttpKernelService',
            'request_stack' => 'getRequestStackService',
            'router' => 'getRouterService',
            'test.client' => 'getTest_ClientService',
        );
        $this->fileMap = array(
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\RedirectController' => __DIR__.'/getRedirectControllerService.php',
            'Symfony\\Bundle\\FrameworkBundle\\Controller\\TemplateController' => __DIR__.'/getTemplateControllerService.php',
            'cache.app' => __DIR__.'/getCache_AppService.php',
            'cache.app_clearer' => __DIR__.'/getCache_AppClearerService.php',
            'cache.global_clearer' => __DIR__.'/getCache_GlobalClearerService.php',
            'cache.system' => __DIR__.'/getCache_SystemService.php',
            'cache.system_clearer' => __DIR__.'/getCache_SystemClearerService.php',
            'cache_clearer' => __DIR__.'/getCacheClearerService.php',
            'cache_warmer' => __DIR__.'/getCacheWarmerService.php',
            'console.command_loader' => __DIR__.'/getConsole_CommandLoaderService.php',
            'filesystem' => __DIR__.'/getFilesystemService.php',
            'routing.loader' => __DIR__.'/getRouting_LoaderService.php',
        );

        $this->aliases = array();
    }

    public function reset()
    {
        $this->privates = array();
        parent::reset();
    }

    public function compile()
    {
        throw new LogicException('You cannot compile a dumped container that was already compiled.');
    }

    public function isCompiled()
    {
        return true;
    }

    public function getRemovedIds()
    {
        return require __DIR__.'/removed-ids.php';
    }

    protected function load($file, $lazyLoad = true)
    {
        return require $file;
    }

    /**
     * Gets the public 'event_dispatcher' shared service.
     *
     * @return \Symfony\Component\EventDispatcher\EventDispatcher
     */
    protected function getEventDispatcherService()
    {
        $this->services['event_dispatcher'] = $instance = new \Symfony\Component\EventDispatcher\EventDispatcher();

        $instance->addListener('kernel.response', array(0 => function () {
            return ($this->privates['response_listener'] ?? $this->privates['response_listener'] = new \Symfony\Component\HttpKernel\EventListener\ResponseListener('UTF-8'));
        }, 1 => 'onKernelResponse'), 0);
        $instance->addListener('kernel.response', array(0 => function () {
            return ($this->privates['streamed_response_listener'] ?? $this->privates['streamed_response_listener'] = new \Symfony\Component\HttpKernel\EventListener\StreamedResponseListener());
        }, 1 => 'onKernelResponse'), -1024);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelRequest'), 16);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ($this->privates['locale_listener'] ?? $this->getLocaleListenerService());
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['validate_request_listener'] ?? $this->privates['validate_request_listener'] = new \Symfony\Component\HttpKernel\EventListener\ValidateRequestListener());
        }, 1 => 'onKernelRequest'), 256);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['resolve_controller_name_subscriber'] ?? $this->getResolveControllerNameSubscriberService());
        }, 1 => 'onKernelRequest'), 24);
        $instance->addListener('console.error', array(0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load(__DIR__.'/getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleError'), -128);
        $instance->addListener('console.terminate', array(0 => function () {
            return ($this->privates['console.error_listener'] ?? $this->load(__DIR__.'/getConsole_ErrorListenerService.php'));
        }, 1 => 'onConsoleTerminate'), -128);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['test.session.listener'] ?? $this->getTest_Session_ListenerService());
        }, 1 => 'onKernelRequest'), 192);
        $instance->addListener('kernel.response', array(0 => function () {
            return ($this->privates['test.session.listener'] ?? $this->getTest_Session_ListenerService());
        }, 1 => 'onKernelResponse'), -128);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'), 2048);
        $instance->addListener('console.command', array(0 => function () {
            return ($this->privates['debug.debug_handlers_listener'] ?? $this->getDebug_DebugHandlersListenerService());
        }, 1 => 'configure'), 2048);
        $instance->addListener('kernel.request', array(0 => function () {
            return ($this->privates['router_listener'] ?? $this->getRouterListenerService());
        }, 1 => 'onKernelRequest'), 32);
        $instance->addListener('kernel.finish_request', array(0 => function () {
            return ($this->privates['router_listener'] ?? $this->getRouterListenerService());
        }, 1 => 'onKernelFinishRequest'), 0);
        $instance->addListener('kernel.controller', array(0 => function () {
            return ($this->privates['pgs_hash_id.event_subscriber.decode_controller_parameters'] ?? $this->getPgsHashId_EventSubscriber_DecodeControllerParametersService());
        }, 1 => 'onKernelController'), 0);

        return $instance;
    }

    /**
     * Gets the public 'http_kernel' shared service.
     *
     * @return \Symfony\Component\HttpKernel\HttpKernel
     */
    protected function getHttpKernelService()
    {
        return $this->services['http_kernel'] = new \Symfony\Component\HttpKernel\HttpKernel(($this->services['event_dispatcher'] ?? $this->getEventDispatcherService()), new \Symfony\Bundle\FrameworkBundle\Controller\ControllerResolver($this, ($this->privates['controller_name_converter'] ?? $this->privates['controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel')))), ($this->privates['logger'] ?? $this->privates['logger'] = new \Symfony\Component\HttpKernel\Log\Logger())), ($this->services['request_stack'] ?? $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack()), new \Symfony\Component\HttpKernel\Controller\ArgumentResolver(new \Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadataFactory(), new RewindableGenerator(function () {
            yield 0 => ($this->privates['argument_resolver.request_attribute'] ?? $this->privates['argument_resolver.request_attribute'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestAttributeValueResolver());
            yield 1 => ($this->privates['argument_resolver.request'] ?? $this->privates['argument_resolver.request'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\RequestValueResolver());
            yield 2 => ($this->privates['argument_resolver.session'] ?? $this->privates['argument_resolver.session'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\SessionValueResolver());
            yield 3 => ($this->privates['argument_resolver.service'] ?? $this->load(__DIR__.'/getArgumentResolver_ServiceService.php'));
            yield 4 => ($this->privates['argument_resolver.default'] ?? $this->privates['argument_resolver.default'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\DefaultValueResolver());
            yield 5 => ($this->privates['argument_resolver.variadic'] ?? $this->privates['argument_resolver.variadic'] = new \Symfony\Component\HttpKernel\Controller\ArgumentResolver\VariadicValueResolver());
        }, 6)));
    }

    /**
     * Gets the public 'request_stack' shared service.
     *
     * @return \Symfony\Component\HttpFoundation\RequestStack
     */
    protected function getRequestStackService()
    {
        return $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack();
    }

    /**
     * Gets the public 'router' shared service.
     *
     * @return \Pgs\HashIdBundle\Decorator\RouterDecorator
     */
    protected function getRouterService()
    {
        $a = new \Symfony\Bundle\FrameworkBundle\Routing\Router($this, ($this->targetDirs[2].'/routing.yml'), array('cache_dir' => $this->targetDirs[0], 'debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'AppTestDebugProjectContainerUrlGenerator', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_base_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'AppTestDebugProjectContainerUrlMatcher', 'strict_requirements' => true), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()));
        $a->setConfigCacheFactory(new \Symfony\Component\Config\ResourceCheckerConfigCacheFactory(new RewindableGenerator(function () {
            yield 0 => ($this->privates['dependency_injection.config.container_parameters_resource_checker'] ?? $this->privates['dependency_injection.config.container_parameters_resource_checker'] = new \Symfony\Component\DependencyInjection\Config\ContainerParametersResourceChecker($this));
            yield 1 => ($this->privates['config.resource.self_checking_resource_checker'] ?? $this->privates['config.resource.self_checking_resource_checker'] = new \Symfony\Component\Config\Resource\SelfCheckingResourceChecker());
        }, 2)));

        return $this->services['router'] = new \Pgs\HashIdBundle\Decorator\RouterDecorator($a, new \Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory(($this->privates['pgs_hash_id.annotation_provider'] ?? $this->getPgsHashId_AnnotationProviderService()), ($this->privates['pgs_hash_id.parameters_processor.no_op'] ?? $this->privates['pgs_hash_id.parameters_processor.no_op'] = new \Pgs\HashIdBundle\ParametersProcessor\NoOp()), new \Pgs\HashIdBundle\ParametersProcessor\Encode(($this->privates['pgs_hash_id.hashids'] ?? $this->privates['pgs_hash_id.hashids'] = new \Hashids\Hashids(NULL, 10, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')))));
    }

    /**
     * Gets the public 'test.client' service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\Client
     */
    protected function getTest_ClientService()
    {
        return new \Symfony\Bundle\FrameworkBundle\Client(($this->services['kernel'] ?? $this->get('kernel')), array(), new \Symfony\Component\BrowserKit\History(), new \Symfony\Component\BrowserKit\CookieJar());
    }

    /**
     * Gets the private 'annotations.reader' shared service.
     *
     * @return \Doctrine\Common\Annotations\AnnotationReader
     */
    protected function getAnnotations_ReaderService()
    {
        $this->privates['annotations.reader'] = $instance = new \Doctrine\Common\Annotations\AnnotationReader();

        $a = new \Doctrine\Common\Annotations\AnnotationRegistry();
        $a->registerUniqueLoader('class_exists');

        $instance->addGlobalIgnoredName('required', $a);

        return $instance;
    }

    /**
     * Gets the private 'debug.debug_handlers_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener
     */
    protected function getDebug_DebugHandlersListenerService()
    {
        return $this->privates['debug.debug_handlers_listener'] = new \Symfony\Component\HttpKernel\EventListener\DebugHandlersListener(NULL, ($this->privates['logger'] ?? $this->privates['logger'] = new \Symfony\Component\HttpKernel\Log\Logger()), -1, -1, true, new \Symfony\Component\HttpKernel\Debug\FileLinkFormatter(NULL), true);
    }

    /**
     * Gets the private 'locale_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\LocaleListener
     */
    protected function getLocaleListenerService()
    {
        return $this->privates['locale_listener'] = new \Symfony\Component\HttpKernel\EventListener\LocaleListener(($this->services['request_stack'] ?? $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack()), 'en', ($this->services['router'] ?? $this->getRouterService()));
    }

    /**
     * Gets the private 'pgs_hash_id.annotation_provider' shared service.
     *
     * @return \Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider
     */
    protected function getPgsHashId_AnnotationProviderService()
    {
        return $this->privates['pgs_hash_id.annotation_provider'] = new \Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider(($this->privates['annotations.reader'] ?? $this->getAnnotations_ReaderService()), new \Pgs\HashIdBundle\Reflection\ReflectionProvider());
    }

    /**
     * Gets the private 'pgs_hash_id.event_subscriber.decode_controller_parameters' shared service.
     *
     * @return \Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber
     */
    protected function getPgsHashId_EventSubscriber_DecodeControllerParametersService()
    {
        return $this->privates['pgs_hash_id.event_subscriber.decode_controller_parameters'] = new \Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber(new \Pgs\HashIdBundle\Service\DecodeControllerParameters(new \Pgs\HashIdBundle\ParametersProcessor\Factory\DecodeParametersProcessorFactory(($this->privates['pgs_hash_id.annotation_provider'] ?? $this->getPgsHashId_AnnotationProviderService()), ($this->privates['pgs_hash_id.parameters_processor.no_op'] ?? $this->privates['pgs_hash_id.parameters_processor.no_op'] = new \Pgs\HashIdBundle\ParametersProcessor\NoOp()), new \Pgs\HashIdBundle\ParametersProcessor\Decode(($this->privates['pgs_hash_id.hashids'] ?? $this->privates['pgs_hash_id.hashids'] = new \Hashids\Hashids(NULL, 10, 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'))))));
    }

    /**
     * Gets the private 'resolve_controller_name_subscriber' shared service.
     *
     * @return \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber
     */
    protected function getResolveControllerNameSubscriberService()
    {
        return $this->privates['resolve_controller_name_subscriber'] = new \Symfony\Bundle\FrameworkBundle\EventListener\ResolveControllerNameSubscriber(($this->privates['controller_name_converter'] ?? $this->privates['controller_name_converter'] = new \Symfony\Bundle\FrameworkBundle\Controller\ControllerNameParser(($this->services['kernel'] ?? $this->get('kernel')))));
    }

    /**
     * Gets the private 'router.request_context' shared service.
     *
     * @return \Symfony\Component\Routing\RequestContext
     */
    protected function getRouter_RequestContextService()
    {
        return $this->privates['router.request_context'] = new \Symfony\Component\Routing\RequestContext('', 'GET', 'localhost', 'http', 80, 443);
    }

    /**
     * Gets the private 'router_listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\RouterListener
     */
    protected function getRouterListenerService()
    {
        return $this->privates['router_listener'] = new \Symfony\Component\HttpKernel\EventListener\RouterListener(($this->services['router'] ?? $this->getRouterService()), ($this->services['request_stack'] ?? $this->services['request_stack'] = new \Symfony\Component\HttpFoundation\RequestStack()), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()), ($this->privates['logger'] ?? $this->privates['logger'] = new \Symfony\Component\HttpKernel\Log\Logger()), $this->targetDirs[4], true);
    }

    /**
     * Gets the private 'test.session.listener' shared service.
     *
     * @return \Symfony\Component\HttpKernel\EventListener\TestSessionListener
     */
    protected function getTest_Session_ListenerService()
    {
        return $this->privates['test.session.listener'] = new \Symfony\Component\HttpKernel\EventListener\TestSessionListener(new \Symfony\Component\DependencyInjection\ServiceLocator(array()));
    }

    public function getParameter($name)
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return $this->buildParameters[$name];
        }

        if (!(isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters))) {
            throw new InvalidArgumentException(sprintf('The parameter "%s" must be defined.', $name));
        }
        if (isset($this->loadedDynamicParameters[$name])) {
            return $this->loadedDynamicParameters[$name] ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
        }

        return $this->parameters[$name];
    }

    public function hasParameter($name)
    {
        $name = (string) $name;
        if (isset($this->buildParameters[$name])) {
            return true;
        }

        return isset($this->parameters[$name]) || isset($this->loadedDynamicParameters[$name]) || array_key_exists($name, $this->parameters);
    }

    public function setParameter($name, $value)
    {
        throw new LogicException('Impossible to call set() on a frozen ParameterBag.');
    }

    public function getParameterBag()
    {
        if (null === $this->parameterBag) {
            $parameters = $this->parameters;
            foreach ($this->loadedDynamicParameters as $name => $loaded) {
                $parameters[$name] = $loaded ? $this->dynamicParameters[$name] : $this->getDynamicParameter($name);
            }
            foreach ($this->buildParameters as $name => $value) {
                $parameters[$name] = $value;
            }
            $this->parameterBag = new FrozenParameterBag($parameters);
        }

        return $this->parameterBag;
    }

    private $loadedDynamicParameters = array(
        'kernel.root_dir' => false,
        'kernel.project_dir' => false,
        'kernel.cache_dir' => false,
        'kernel.logs_dir' => false,
        'kernel.bundles_metadata' => false,
        'debug.container.dump' => false,
        'router.resource' => false,
    );
    private $dynamicParameters = array();

    /**
     * Computes a dynamic parameter.
     *
     * @param string The name of the dynamic parameter to load
     *
     * @return mixed The value of the dynamic parameter
     *
     * @throws InvalidArgumentException When the dynamic parameter does not exist
     */
    private function getDynamicParameter($name)
    {
        switch ($name) {
            case 'kernel.root_dir': $value = $this->targetDirs[2]; break;
            case 'kernel.project_dir': $value = $this->targetDirs[4]; break;
            case 'kernel.cache_dir': $value = $this->targetDirs[0]; break;
            case 'kernel.logs_dir': $value = ($this->targetDirs[2].'/logs'); break;
            case 'kernel.bundles_metadata': $value = array(
                'FrameworkBundle' => array(
                    'path' => ($this->targetDirs[4].'/vendor/symfony/framework-bundle'),
                    'namespace' => 'Symfony\\Bundle\\FrameworkBundle',
                ),
                'PgsHashIdBundle' => array(
                    'path' => ($this->targetDirs[4].'/src'),
                    'namespace' => 'Pgs\\HashIdBundle',
                ),
            ); break;
            case 'debug.container.dump': $value = ($this->targetDirs[0].'/AppTestDebugProjectContainer.xml'); break;
            case 'router.resource': $value = ($this->targetDirs[2].'/routing.yml'); break;
            default: throw new InvalidArgumentException(sprintf('The dynamic parameter "%s" must be defined.', $name));
        }
        $this->loadedDynamicParameters[$name] = true;

        return $this->dynamicParameters[$name] = $value;
    }

    /**
     * Gets the default parameters.
     *
     * @return array An array of the default parameters
     */
    protected function getDefaultParameters()
    {
        return array(
            'kernel.environment' => 'test',
            'kernel.debug' => true,
            'kernel.name' => 'App',
            'kernel.bundles' => array(
                'FrameworkBundle' => 'Symfony\\Bundle\\FrameworkBundle\\FrameworkBundle',
                'PgsHashIdBundle' => 'Pgs\\HashIdBundle\\PgsHashIdBundle',
            ),
            'kernel.charset' => 'UTF-8',
            'kernel.container_class' => 'AppTestDebugProjectContainer',
            'fragment.renderer.hinclude.global_template' => '',
            'fragment.path' => '/_fragment',
            'kernel.secret' => 'secret',
            'kernel.http_method_override' => true,
            'kernel.trusted_hosts' => array(

            ),
            'kernel.default_locale' => 'en',
            'templating.helper.code.file_link_format' => NULL,
            'debug.file_link_format' => NULL,
            'test.client.parameters' => array(

            ),
            'data_collector.templates' => array(

            ),
            'debug.error_handler.throw_at' => -1,
            'router.request_context.host' => 'localhost',
            'router.request_context.scheme' => 'http',
            'router.request_context.base_url' => '',
            'router.cache_class_prefix' => 'AppTestDebugProjectContainer',
            'request_listener.http_port' => 80,
            'request_listener.https_port' => 443,
            'pgs_hash_id.hashids.class' => 'Hashids\\Hashids',
            'pgs_hash_id.decorator.router.class' => 'Pgs\\HashIdBundle\\Decorator\\RouterDecorator',
            'pgs_hash_id.reflection_provider.class' => 'Pgs\\HashIdBundle\\Reflection\\ReflectionProvider',
            'pgs_hash_id.annotation_provider.class' => 'Pgs\\HashIdBundle\\AnnotationProvider\\AnnotationProvider',
            'pgs_hash_id.parameters_processor.encode.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\Encode',
            'pgs_hash_id.parameters_processor.decode.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\Decode',
            'pgs_hash_id.parameters_processor.no_op.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\NoOp',
            'pgs_hash_id.parameters_processor.factory.abstract.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\Factory\\AbstractParametersProcessorFactory',
            'pgs_hash_id.parameters_processor.factory.encode.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\Factory\\EncodeParametersProcessorFactory',
            'pgs_hash_id.parameters_processor.factory.decode.class' => 'Pgs\\HashIdBundle\\ParametersProcessor\\Factory\\DecodeParametersProcessorFactory',
            'pgs_hash_id.event_subscriber.decode_controller_parameters.class' => 'Pgs\\HashIdBundle\\EventSubscriber\\DecodeControllerParametersSubscriber',
            'pgs_hash_id.service.decode_controller_parameters.class' => 'Pgs\\HashIdBundle\\Service\\DecodeControllerParameters',
            'pgs_hash_id.salt' => NULL,
            'pgs_hash_id.min_hash_length' => 10,
            'pgs_hash_id.alphabet' => 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890',
            'console.command.ids' => array(

            ),
        );
    }
}
