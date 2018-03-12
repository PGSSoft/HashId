<?php


namespace Pgs\HashIdBundle\Tests;


use Pgs\HashIdBundle\DependencyInjection\Compiler\EventSubscriberCompilerPass;
use Pgs\HashIdBundle\DependencyInjection\PgsHashIdExtension;
use Pgs\HashIdBundle\PgsHashIdBundle;
use PHPUnit\Framework\TestCase;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class PgsHashIdBundleTest extends TestCase
{
    public function testGetContainerExtension(): void
    {
        $bundle = new PgsHashIdBundle();
        $this->assertInstanceOf(PgsHashIdExtension::class, $bundle->getContainerExtension());
    }

    public function testRegisterCompilerPass(): void
    {
        $container = new ContainerBuilder();
        $bundle = new PgsHashIdBundle();
        $bundle->build($container);
        $passes = $container->getCompilerPassConfig()->getPasses();
        $passesClasses = array_map(function ($item) {
            return \get_class($item);
        }, $passes);

        $this->assertTrue(\in_array(EventSubscriberCompilerPass::class, $passesClasses, true));
    }
}