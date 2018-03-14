<?php

namespace Pgs\HashIdBundle\DependencyInjection;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Pgs\HashIdBundle\Annotation\Hash;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\HttpKernel\DependencyInjection\Extension;

class PgsHashIdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container): void
    {
        $loader = new YamlFileLoader(
            $container,
            new FileLocator(__DIR__.'/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);
        $container->setParameter('pgs_hash_id.salt', $config['salt']);
        $container->setParameter('pgs_hash_id.min_hash_length', $config['min_hash_length']);
        $container->setParameter('pgs_hash_id.alphabet', $config['alphabet']);

        $this->registerAnnotation();
    }

    private function registerAnnotation(): void
    {
        AnnotationRegistry::loadAnnotationClass(Hash::class);
    }
}
