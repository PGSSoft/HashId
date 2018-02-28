<?php


namespace Pgs\HashIdBundle\Tests\DependencyInjection;


use Pgs\HashIdBundle\DependencyInjection\HashIdExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HashIdExtensionTest extends TestCase
{
    public function testExtensionLoad()
    {
        $container = new ContainerBuilder();

        $extension = new HashIdExtension();
        $extension->load([], $container);
        $this->assertTrue($container->hasParameter('pgs_hash_id.salt'));
        $this->assertTrue($container->hasParameter('pgs_hash_id.min_hash_length'));
        $this->assertTrue($container->hasParameter('pgs_hash_id.alphabet'));
    }
}