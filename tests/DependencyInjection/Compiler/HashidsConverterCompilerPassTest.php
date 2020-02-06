<?php

namespace Pgs\HashIdBundle\Tests\DependencyInjection\Compiler;

use Hashids\Hashids;
use Pgs\HashIdBundle\DependencyInjection\Compiler\HashidsConverterCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class HashidsConverterCompilerPassTest extends TestCase
{
    /**
     * @var CompilerPassInterface
     */
    private $compilerPass;

    /**
     * @var ContainerBuilder
     */
    private $container;

    protected function setUp()
    {
        $this->compilerPass = new HashidsConverterCompilerPass();

        $this->container = new ContainerBuilder();

        if ($this->doesHashidsExist()) {
            $this->container->setParameter('pgs_hash_id.converter.hashids.salt', 'salt');
            $this->container->setParameter('pgs_hash_id.converter.hashids.min_hash_length', 10);
            $this->container->setParameter('pgs_hash_id.converter.hashids.alphabet', 'alphabet');
        }
    }

    public function testHasServiceDefinitionsIfHashidsExists()
    {
        $this->compilerPass->process($this->container);

        if ($this->doesHashidsExist()) {
            $this->assertTrue($this->container->hasDefinition('pgs_hash_id.hashids'));
            $this->assertTrue($this->container->hasDefinition('pgs_hash_id.converter.hashids'));
            $this->assertTrue($this->container->hasAlias('pgs_hash_id.converter'));
        }
    }

    private function doesHashidsExist()
    {
        return class_exists(Hashids::class);
    }
}
