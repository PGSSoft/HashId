<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\Service\Sf34;

use Pgs\HashIdBundle\Service\AbstractDecodeControllerParameters;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;

class DecodeControllerParameters extends AbstractDecodeControllerParameters
{
    public function decodeControllerParameters(FilterControllerEvent $event): void
    {
        $controller = $event->getController();
        $parametersProcessor = $this
            ->getParametersProcessorFactory()
            ->createControllerDecodeParametersProcessor(...$controller);

        $this->processRequestParameters($event, $parametersProcessor);
        $this->processRequestParametersWithParamConverter($event);
    }
}
