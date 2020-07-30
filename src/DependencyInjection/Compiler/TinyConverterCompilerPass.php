<?php

namespace Pgs\HashIdBundle\DependencyInjection\Compiler;

use Hashids\Hashids;
use Pgs\HashIdBundle\ParametersProcessor\Converter\TinyConverter;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class TinyConverterCompilerPass extends AbstractConverterCompilerPass
{
    protected function registerService(ContainerBuilder $container): void
    {
        $serviceDefinition = new Definition(
            Hashids::class,
            [
                $container->getParameter(
                    sprintf('pgs_hash_id.converter.%s.set', $this->getConverterName())
                ),
            ]
        );
        $serviceDefinition->setPublic(false);

        $container->addDefinitions([sprintf('pgs_hash_id.%s', $this->getConverterName()) => $serviceDefinition]);
    }

    protected function getSupportedClass(): string
    {
//        return Tiny::class;
    }

    protected function getConverterClass(): string
    {
        return TinyConverter::class;
    }

    protected function getConverterName(): string
    {
        return 'tiny';
    }
}
