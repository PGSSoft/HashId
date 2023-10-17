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
    protected static $container;

    protected function setUp(): void
    {
        $this::$container = static::createClient()->getContainer();
        $this->router = self::$container->get('router');
    }

    public function testGenerateUrl(): void
    {
        $id = 10;
        $other = 20;
        $alphabet = self::$container->getParameter('pgs_hash_id.converter.hashids.alphabet');
        $hashLength = self::$container->getParameter('pgs_hash_id.converter.hashids.min_hash_length');

        $routeArgs = ['pgs_hash_id_demo_decode', ['id' => $id, 'other' => $other]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertNotSame(sprintf('/hash-id/demo/decode/%d/%d', $id, $other), $generatedPath);
        $pattern = sprintf('/\/hash-id\/demo\/decode\/[%s]{%d}\/\d+/', $alphabet, $hashLength);
        $this->assertRegExp($pattern, $generatedPath);

        $routeArgs = ['pgs_hash_id_demo_encode_localized', ['id' => $id, '_locale' => 'pl']];
        $generatedPath = $this->router->generate(...$routeArgs);
        $this->assertNotSame(sprintf('/hash-id/demo/encode-pl/%d', $id), $generatedPath);
        $pattern = sprintf('/\/hash-id\/demo\/encode-pl\/[%s]{%d}/', $alphabet, $hashLength);
        $this->assertRegExp($pattern, $generatedPath);

        $routeArgs = ['pgs_hash_id_demo_decode_more', ['id' => $id, 'other' => $other]];
        $generatedPath = $this->router->generate(...$routeArgs);
        $pattern = sprintf(
            '/\/hash-id\/demo\/decode_more\/[%s]{%d}\/[%s]{%d}/',
            $alphabet,
            $hashLength,
            $alphabet,
            $hashLength
        );
        $this->assertRegExp($pattern, $generatedPath);
    }
}
