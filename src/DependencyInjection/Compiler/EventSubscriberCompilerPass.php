<?php

namespace Pgs\HashIdBundle\DependencyInjection\Compiler;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

class EventSubscriberCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        if ($container->hasDefinition('sensio_framework_extra.converter.listener')) {
            $paramConverterListener = $container->getDefinition('sensio_framework_extra.converter.listener');
            $paramConverterListener->clearTag('kernel.event_subscriber');

            $decodeControllerParameters = $container->getDefinition('pgs_hash_id.service.decode_controller_parameters');
            $decodeControllerParameters->addMethodCall(
                'setParamConverterListener',
                [new Reference('sensio_framework_extra.converter.listener')]
            );
        }
    }
}
