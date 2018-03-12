<?php


namespace Pgs\HashIdBundle\Tests\EventSubscriber;


use Pgs\HashIdBundle\EventSubscriber\DecodeControllerParametersBeforeParamConverterSubscriber;
use Pgs\HashIdBundle\Exception\MissingDependencyException;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Sensio\Bundle\FrameworkExtraBundle\Request\ParamConverter\ParamConverterManager;

class DecodeControllerParametersBeforeParamConverterSubscriberTest extends AbstractEventSubscriberTest
{
    public function testSubscribedEvents(): void
    {
        $this->subscribedEventsList(DecodeControllerParametersBeforeParamConverterSubscriber::class);
    }

    public function testSetAndGetDecodeControllerParameters(): void
    {
        $subscriber = $this->getSubscriber();
        $decodeControllerParameters = $this->createMock(DecodeControllerParameters::class);
        $subscriber->setDecodeControllerParameters($decodeControllerParameters);
        $this->assertEquals($decodeControllerParameters, $subscriber->getDecodeControllerParameters());
    }

    public function testNonSetDecodeControllerParameters(): void
    {
        $this->expectException(MissingDependencyException::class);
        $subscriber = $this->getSubscriber();
        $subscriber->getDecodeControllerParameters();
    }

    protected function getSubscriber(): DecodeControllerParametersBeforeParamConverterSubscriber
    {
        $subscriber = new DecodeControllerParametersBeforeParamConverterSubscriber(
            $this->createMock(ParamConverterManager::class),
            true
        );

        return $subscriber;
    }


}