<?php

namespace Pgs\HashIdBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeDefinition;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

class RootNodeFactory
{
    public static function create(TreeBuilder $treeBuilder, string $nodeName): NodeDefinition
    {
        return self::isSymfonyConfigGt41($treeBuilder) ?
            $treeBuilder->getRootNode() :
            /* @scrutinizer ignore-deprecated */
            $treeBuilder->root($nodeName);
    }

    public static function isSymfonyConfigGt41(TreeBuilder $treeBuilder)
    {
        return method_exists($treeBuilder, 'getRootNode');
    }
}
