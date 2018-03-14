<?php

namespace DependencyInjection\Compiler;

use Pgs\HashIdBundle\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Definition;

class EventSubscriberCompilerPassTest extends TestCase
{
    /**
     * @var CompilerPassInterface
     */
    private $pass;

    /**
     * @var ContainerBuilder
     */
    private $container;

    /**
     * @var Definition
     */
    private $paramConverterListenerDefinition;

    /**
     * @var Definition
     */
    private $decodeControllerParametersDefinition;

    protected function setUp()
    {
        $this->pass = new EventSubscriberCompilerPass();
        $this->container = new ContainerBuilder();

        $paramConverterListenerDefinition = new Definition();
        $paramConverterListenerDefinition->addTag('kernel.event_subscriber');
        $this->paramConverterListenerDefinition = $paramConverterListenerDefinition;
        $this->container->setDefinition('sensio_framework_extra.converter.listener', $this->paramConverterListenerDefinition);

        $this->decodeControllerParametersDefinition = new Definition();
        $this->container->setDefinition('pgs_hash_id.service.decode_controller_parameters', $this->decodeControllerParametersDefinition);
    }

    public function testProcessForExistingParamConverterListener(): void
    {
        $this->pass->process($this->container);
        $listenerDefinition = $this->container->getDefinition('sensio_framework_extra.converter.listener');
        $this->assertFalse($listenerDefinition->hasTag('kernel.event_subscriber'));
    }
}
