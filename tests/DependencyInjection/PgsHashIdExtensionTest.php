<?php

namespace Pgs\HashIdBundle\Tests\DependencyInjection;

use Pgs\HashIdBundle\DependencyInjection\PgsHashIdExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PgsHashIdExtensionTest extends TestCase
{
    public function testExtensionLoad(): void
    {
        $container = new ContainerBuilder();

        $extension = new PgsHashIdExtension();
        $extension->load([], $container);
        $this->assertTrue($container->hasParameter('pgs_hash_id.salt'));
        $this->assertTrue($container->hasParameter('pgs_hash_id.min_hash_length'));
        $this->assertTrue($container->hasParameter('pgs_hash_id.alphabet'));
    }
}
