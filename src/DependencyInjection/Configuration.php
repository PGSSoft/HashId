<?php

namespace Pgs\HashIdBundle\DependencyInjection;

use Hashids\Hashids;
use Symfony\Component\Config\Definition\Builder\ArrayNodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    const ROOT_NAME = 'pgs_hash_id';

    const NODE_CONVERTER = 'converter';
    const NODE_CONVERTER_HASHIDS = 'hashids';
    const NODE_CONVERTER_HASHIDS_SALT = 'salt';
    const NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH = 'min_hash_length';
    const NODE_CONVERTER_HASHIDS_ALPHABET = 'alphabet';

    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder(self::ROOT_NAME);
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = /* @scrutinizer ignore-deprecated */ $treeBuilder->root(self::ROOT_NAME);
        }

        $rootNode
            ->children()
                ->arrayNode(self::NODE_CONVERTER)->addDefaultsIfNotSet()
                    ->children()
                        ->append($this->addHashidsConverterNode())
                    ->end()
                ->end()
            ->end();

        return $treeBuilder;
    }

    private function addHashidsConverterNode(): ArrayNodeDefinition
    {
        $node = new ArrayNodeDefinition(self::NODE_CONVERTER_HASHIDS);

        if (!class_exists(Hashids::class)) {
            return $node;
        }

        return $node
            ->addDefaultsIfNotSet()
                ->children()
                    ->scalarNode(self::NODE_CONVERTER_HASHIDS_SALT)
                        ->defaultNull()
                    ->end()
                    /* @scrutinizer ignore-call */
                    ->scalarNode(self::NODE_CONVERTER_HASHIDS_MIN_HASH_LENGTH)
                        ->defaultValue(10)
                    ->end()
                    ->scalarNode(self::NODE_CONVERTER_HASHIDS_ALPHABET)
                        ->defaultValue('abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890')
                    ->end()
                ->end();
    }
}
