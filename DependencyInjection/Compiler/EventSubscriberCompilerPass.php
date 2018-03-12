<?php


namespace Pgs\HashIdBundle\DependencyInjection\Compiler;


use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersBeforeParamConverterSubscriber;
use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;

class EventSubscriberCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $pgsHashIdDecodeControllerParametersSubscriberDefinition = new Definition(DecodeControllerParametersSubscriber::class, [new Reference('pgs_hash_id.service.decode_controller_parameters')]);
        $pgsHashIdDecodeControllerParametersSubscriberDefinition->addTag('kernel.event_subscriber');
        $container->addDefinitions([
            'pgs_hash_id.event_subscriber.decode_controller_parameters' => $pgsHashIdDecodeControllerParametersSubscriberDefinition
        ]);

        if ($container->hasDefinition('sensio_framework_extra.converter.listener')) {
            $paramConverterListenerDefinition = $container->getDefinition('sensio_framework_extra.converter.listener');
            $paramConverterListenerDefinition->clearTag('kernel.event_subscriber');

            $decodeControllerParametersDefinition = $container->getDefinition('pgs_hash_id.service.decode_controller_parameters');
            $decodeControllerParametersDefinition->addMethodCall('setParamConverterListener', [new Reference('sensio_framework_extra.converter.listener')]);
//            $paramConverterListenerDefinition->setClass(DecodeControllerParametersBeforeParamConverterSubscriber::class);
//            $paramConverterListenerDefinition->addMethodCall('setDecodeControllerParameters', [new Reference('pgs_hash_id.service.decode_controller_parameters')]);
        }
    }
}