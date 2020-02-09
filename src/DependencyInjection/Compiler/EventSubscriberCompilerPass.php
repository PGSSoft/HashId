<?php

namespace Pgs\HashIdBundle\DependencyInjection\Compiler;

use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersSubscriber;
use Pgs\HashIdBundle\EventSubscriber\Sf34\DecodeControllerParametersSubscriber as Sf34DecodeControllerParametersSubscriber;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Pgs\HashIdBundle\Service\Sf34\DecodeControllerParameters as Sf34DecodeControllerParameters;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;
use Symfony\Component\DependencyInjection\Reference;
use Symfony\Component\HttpKernel\Event\ControllerEvent;

class EventSubscriberCompilerPass implements CompilerPassInterface
{
    public function process(ContainerBuilder $container): void
    {
        $this->defineDecodeControllerParametersSubscriber($container);

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

    private function defineDecodeControllerParametersSubscriber(ContainerBuilder $container)
    {
        if (!class_exists(ControllerEvent::class)) {
            $eventSubscriberClass = Sf34DecodeControllerParametersSubscriber::class;
            $decodeControllerParametersClass = Sf34DecodeControllerParameters::class;
        } else {
            $eventSubscriberClass = DecodeControllerParametersSubscriber::class;
            $decodeControllerParametersClass = DecodeControllerParameters::class;
        }
        $decodeControllerParametersServiceDefinition = new Definition($decodeControllerParametersClass, [
            new Reference('pgs_hash_id.parameters_processor.factory.decode')
        ]);
        $decodeControllerParametersServiceDefinition->setPublic(false);

        $eventSubscriberDefinition = new Definition(
            $eventSubscriberClass,
            [new Reference('pgs_hash_id.service.decode_controller_parameters')]
        );
        $eventSubscriberDefinition->addTag('kernel.event_subscriber');
        $container->addDefinitions([
            'pgs_hash_id.service.decode_controller_parameters' => $decodeControllerParametersServiceDefinition,
            'pgs_hash_id.event_subscriber.decode_controller_parameters' => $eventSubscriberDefinition
        ]);

    }
}
