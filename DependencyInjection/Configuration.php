<?php


namespace Pgs\HashIdBundle\DependencyInjection;


use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT_NAME = 'hash_id';

    const NODE_SALT = 'salt';
    const NODE_MIN_HASH_LENGTH = 'min_hash_length';
    const NODE_ALPHABET = 'alphabet';


    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root(self::ROOT_NAME);
        $rootNode
            ->children()
                ->scalarNode(self::NODE_SALT)->defaultNull()->end()
                ->scalarNode(self::NODE_MIN_HASH_LENGTH)->defaultValue(10)->end()
                ->scalarNode(self::NODE_ALPHABET)->defaultValue('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')->end()
            ->end();

        return $treeBuilder;
    }
}