<?php


namespace Pgs\HashIdBundle\Tests\Decorator;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;


class RouterDecoratorTest extends WebTestCase
{
    /**
     * @var RouterInterface
     */
    private $router = null;

    protected function setUp()
    {
        $this->router = static::createClient()->getContainer()->get('router');
    }

    public function testIsIdDifferent()
    {
        $id = 10;
        $routeArgs = ['pgs_hash_id_demo', ['id' => $id]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertNotEquals(sprintf('/hash-id/demo/%d', $id), $generatedPath);
        $this->assertTrue(preg_match('/\/hash-id\/demo\/\w+/', $generatedPath) === 1);
    }
}