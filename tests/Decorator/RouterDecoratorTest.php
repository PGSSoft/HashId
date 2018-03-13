<?php


namespace Pgs\HashIdBundle\Tests\Decorator;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\DependencyInjection\Container;
use Symfony\Component\Routing\RouterInterface;


class RouterDecoratorTest extends WebTestCase
{
    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var Container
     */
    private $container;

    protected function setUp()
    {
        $this->container = static::createClient()->getContainer();
        $this->router = $this->container->get('router');

    }

    public function testGenerateUrl(): void
    {
        $id = 10;
        $other = 20;
        $alphabet = $this->container->getParameter('pgs_hash_id.alphabet');
        $routeArgs = ['pgs_hash_id_demo_decode', ['id' => $id, 'other' => $other]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertNotEquals(sprintf('/hash-id/demo/decode/%d/%d', $id, $other), $generatedPath);
        $this->assertSame(1, preg_match(sprintf('/\/hash-id\/demo\/decode\/[%s]+\/\d+/', $alphabet), $generatedPath));

        $routeArgs = ['pgs_hash_id_demo_decode_more', ['id' => $id, 'other' => $other]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertSame(1, preg_match(sprintf('/\/hash-id\/demo\/decode_more\/[%s]+\/[%s]+/', $alphabet, $alphabet), $generatedPath));
    }
}