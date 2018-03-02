<?php


namespace Pgs\HashIdBundle\Tests\ParametersProcessor\Factory;


use Pgs\HashIdBundle\ParametersProcessor\Encode;
use Pgs\HashIdBundle\ParametersProcessor\Factory\EncodeParametersProcessorFactory;
use Pgs\HashIdBundle\ParametersProcessor\NoOp;

class EncodeParametersProcessorFactoryTest extends ParametersProcessorFactoryTest
{

    public function testCreateRouteEncodeParametersProcessor(): void
    {
        $encodeParametersProcessor = $this->getParametersProcessorMock(Encode::class);
        $noOpParametersProcessor = $this->getParametersProcessorMock(NoOp::class);
        $parametersProcessorFactory = new EncodeParametersProcessorFactory(
            $this->getExistingControllerAnnotationProviderMock(),
            $noOpParametersProcessor,
            $encodeParametersProcessor
        );

        $parametersProcessor = $parametersProcessorFactory->createRouteEncodeParametersProcessor($this->getTestRouteMock());
        $this->assertInstanceOf(\get_class($encodeParametersProcessor), $parametersProcessor);
    }

    public function testCreateRouteNoOpParametersProcessor(): void
    {
        $encodeParametersProcessor = $this->getParametersProcessorMock(Encode::class);
        $noOpParametersProcessor = $this->getParametersProcessorMock(NoOp::class);
        $parametersProcessorFactory = new EncodeParametersProcessorFactory(
            $this->getNotExistingControllerAnnotationProviderMock(),
            $noOpParametersProcessor,
            $encodeParametersProcessor
        );

        $parametersProcessor = $parametersProcessorFactory->createRouteEncodeParametersProcessor($this->getTestRouteMock());
        $this->assertInstanceOf(\get_class($noOpParametersProcessor), $parametersProcessor);

        $parametersProcessorFactory = new EncodeParametersProcessorFactory(
            $this->getExceptionThrowControllerAnnotationProviderMock(),
            $noOpParametersProcessor,
            $encodeParametersProcessor
        );
        $parametersProcessor = $parametersProcessorFactory->createRouteEncodeParametersProcessor($this->getInvalidRouteMock());
        $this->assertInstanceOf(\get_class($noOpParametersProcessor), $parametersProcessor);

    }
}