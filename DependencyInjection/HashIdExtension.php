<?php


namespace Pgs\HashIdBundle\DependencyInjection;


use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;

class HashIdExtension extends Extension
{
    public function load(array $configs, ContainerBuilder $container)
    {
        $c = $configs;echo "dddd";
    }

}