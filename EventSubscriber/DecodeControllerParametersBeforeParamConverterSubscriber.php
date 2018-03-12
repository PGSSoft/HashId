<?php


namespace Pgs\HashIdBundle\EventSubscriber;


use Pgs\HashIdBundle\Exception\MissingDependencyException;
use Pgs\HashIdBundle\Service\DecodeControllerParameters;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\ParamConverterListener;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParametersBeforeParamConverterSubscriber implements EventSubscriberInterface
{
    protected $decodeControllerParameters;

    /**
     * @codeCoverageIgnore
     */
    public function onKernelController(FilterControllerEvent $event): void
    {
        $this->getDecodeControllerParameters()->decodeControllerParameters($event);
        parent::onKernelController($event);
    }

    public function setDecodeControllerParameters(DecodeControllerParameters $decodeControllerParameters): void
    {
        $this->decodeControllerParameters = $decodeControllerParameters;
    }

    /**
     * @throws MissingDependencyException
     * @return DecodeControllerParameters
     */
    public function getDecodeControllerParameters(): DecodeControllerParameters
    {
        if ($this->decodeControllerParameters === null){
            throw new MissingDependencyException(sprintf('Missing %s for %s', DecodeControllerParameters::class, \get_class($this)));
        }
        return $this->decodeControllerParameters;
    }

    public static function getSubscribedEvents()
    {
    }

}