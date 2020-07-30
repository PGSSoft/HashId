<?php

namespace Pgs\HashIdBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Alias;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

abstract class AbstractConverterCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container)
    {
        if (!class_exists($this->getSupportedClass())) {
            return;
        }

        $this->registerService($container);
        $this->registerConverter($container);
        $this->setConverterAsDefault($container);
    }

    abstract protected function getSupportedClass(): string;

    abstract protected function registerService(ContainerBuilder $container): void;

    protected function registerConverter(ContainerBuilder $container): void
    {
        $converterDefinition = new Definition(
            $this->getConverterClass(),
            [
                new Reference(sprintf('pgs_hash_id.%s', $this->getConverterName())),
            ]
        );

        $container->addDefinitions([
            sprintf('pgs_hash_id.converter.%s', $this->getConverterName()) => $converterDefinition,
        ]);
    }

    abstract protected function getConverterClass(): string;

    abstract protected function getConverterName(): string;

    protected function setConverterAsDefault(ContainerBuilder $container): void
    {
        $converterServiceId = 'pgs_hash_id.converter';
        if (!$container->hasAlias($converterServiceId)) {
            $converterServiceAlias = new Alias(sprintf('pgs_hash_id.converter.%s', $this->getConverterName()));
            $container->addAliases([$converterServiceId => $converterServiceAlias]);
        }
    }
}
