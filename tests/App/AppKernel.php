<?php


namespace Pgs\HashIdBundle\Tests\App;


use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\Config\Loader\LoaderInterface;
use Symfony\Component\HttpKernel\Kernel;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = [
            \Symfony\Bundle\FrameworkBundle\FrameworkBundle::class => ['all' => true],
            \Pgs\HashIdBundle\PgsHashIdBundle::class => ['all' => true],
        ];
        foreach ($bundles as $class => $envs) {
            if (isset($envs['all']) || isset($envs[$this->environment])) {
                yield new $class();
            }
        }
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load(__DIR__.'/config.yml');
    }

}