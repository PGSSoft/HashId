<?php


namespace Pgs\HashIdBundle\Tests\Decorator;


use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Routing\RouterInterface;


class RouterDecoratorTest extends WebTestCase
{
    /**
     * @var RouterInterface
     */
    private $router;

    protected function setUp()
    {
        $this->router = static::createClient()->getContainer()->get('router');
    }

    public function testIsIdDifferent(): void
    {
        $id = 10;
        $other = 20;
        $routeArgs = ['pgs_hash_id_demo_decode', ['id' => $id, 'other' => $other]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertNotEquals(sprintf('/hash-id/demo/decode/%d/%d', $id, $other), $generatedPath);
        $this->assertSame(1, preg_match('/\/hash-id\/demo\/decode\/\w+\/\w+/', $generatedPath));
    }
}