<?php


namespace Pgs\HashIdBundle\EventSubscriber;


use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParametersBeforeParamConverterSubscriber extends ParamConverterListener
{
    protected $decodeControllerParameters;

    public function onKernelController(FilterControllerEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
        parent::onKernelController($event);
    }

    public function setDecodeControllerParameters(DecodeControllerParameters $decodeControllerParameters): void
    {
        $this->decodeControllerParameters = $decodeControllerParameters;
    }

    public function getDecodeControllerParameters(): DecodeControllerParameters
    {
        return $this->decodeControllerParameters;
    }
}