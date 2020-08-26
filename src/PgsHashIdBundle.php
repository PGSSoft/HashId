<?php

namespace Pgs\HashIdBundle;

use Pgs\HashIdBundle\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Pgs\HashIdBundle\DependencyInjection\Compiler\HashidsConverterCompilerPass;
use Pgs\HashIdBundle\DependencyInjection\Compiler\TinyConverterCompilerPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

class PgsHashIdBundle extends Bundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);
        $container->addCompilerPass(new HashidsConverterCompilerPass());
        $container->addCompilerPass(new TinyConverterCompilerPass());
        $container->addCompilerPass(new EventSubscriberCompilerPass());
    }
}
