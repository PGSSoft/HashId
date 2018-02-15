<?php


namespace Pgs\HashIdBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('pgs_hash_id');
        $rootNode
            ->children()
            ->scalarNode('salt')->defaultNull()->end()
            ->scalarNode('min_hash_length')->defaultValue(0)->end()
            ->scalarNode('alphabet')->defaultValue('')->end();

        return $treeBuilder;
    }
}