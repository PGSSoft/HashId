<?php


namespace Pgs\HashIdBundle\Tests\Decorator;


use Pgs\HashIdBundle\Decorator\RouterDecorator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Bundle\FrameworkBundle\Tests\TestCase;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\Routing\Route;
use Symfony\Component\Routing\Router;
use Symfony\Component\Routing\RouterInterface;

class RouterDecoratorTest extends WebTestCase
{
    /**
     * @var RouterInterface
     */
    private $router = null;

    private $loader = null;

    protected function setUp()
    {
        $this->router = static::createClient()->getContainer()->get('router');
        $this->loader = $this->getMockBuilder(LoaderInterface::class)->getMock();

//        $this->router = new Router($this->loader, 'routing.yml');
//        $this->services['router'] = $instance = new \Symfony\Bundle\FrameworkBundle\Routing\Router($this, 'kernel:loadRoutes', array('cache_dir' => $this->targetDirs[0], 'debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'srcDevDebugProjectContainerUrlGenerator', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_base_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'srcDevDebugProjectContainerUrlMatcher', 'strict_requirements' => true, 'resource_type' => 'service'), ($this->privates['router.request_context'] ?? $this->getRouter_RequestContextService()));
//        $this->router = $instance = new Router($this->loader, 'kernel:loadRoutes', array('debug' => true, 'generator_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_base_class' => 'Symfony\\Component\\Routing\\Generator\\UrlGenerator', 'generator_dumper_class' => 'Symfony\\Component\\Routing\\Generator\\Dumper\\PhpGeneratorDumper', 'generator_cache_class' => 'srcDevDebugProjectContainerUrlGenerator', 'matcher_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_base_class' => 'Symfony\\Bundle\\FrameworkBundle\\Routing\\RedirectableUrlMatcher', 'matcher_dumper_class' => 'Symfony\\Component\\Routing\\Matcher\\Dumper\\PhpMatcherDumper', 'matcher_cache_class' => 'srcDevDebugProjectContainerUrlMatcher', 'strict_requirements' => true, 'resource_type' => 'service'));
//        $this->router = $this->getRouterMock();
    }

    public function testIsIdDifferent()
    {
        $routeArgs = ['pgs_hash_id_demo', ['max'=> 100, 'id' => 10]];
        $notDecoratedRoute = $this->router->generate(...$routeArgs);
        $decoratedRouter = new RouterDecorator($this->router);
        $decoratedRoute = $decoratedRouter->generate(...$routeArgs);
//        var_dump($notDecoratedRoute, $decoratedRoute);
        $this->assertNotEquals($decoratedRoute, $notDecoratedRoute);
    }

//    protected function getRouter(){
//        return self::getKernel()->getContainer()->get('router');
//    }

    protected function getRouterMock()
    {
        $mock = $this->getMockBuilder('\Symfony\Bundle\FrameworkBundle\Routing\Router')
            ->disableOriginalConstructor()
            ->setMethods(['generate', 'supports', 'exists'])
            ->getMockForAbstractClass();

        $args = ['crmpiccobundle_portal_billing', [
            'subdomain' => "crmpicco",
        ], true];

        $mock->expects($this->any())
            ->method('generate')
            ->with($args)
            ->will($this->returnValue('https://www.crmpicco.co.uk/en/admin/billing'));

        return $mock;
    }
}