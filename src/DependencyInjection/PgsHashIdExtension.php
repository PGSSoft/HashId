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
            new FileLocator(__DIR__ . '/../Resources/config')
        );
        $loader->load('services.yaml');

        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, $configs);

        foreach ($config[Configuration::NODE_CONVERTER] as $converter => $parameters) {
            foreach ($parameters as $parameter => $value){
                $container->setParameter(sprintf('pgs_hash_id.converter.%s.%s', $converter, $parameter), $value);
            }
        }

        $this->registerAnnotation();
    }

    private function registerAnnotation(): void
    {
        AnnotationRegistry::loadAnnotationClass(Hash::class);
    }
}
