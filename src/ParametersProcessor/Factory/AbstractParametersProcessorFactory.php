<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor\Factory;

use Pgs\HashIdBundle\AnnotationProvider\AnnotationProvider;
use Pgs\HashIdBundle\ParametersProcessor\ParametersProcessorInterface;

abstract class AbstractParametersProcessorFactory
{
    /**
     * @var AnnotationProvider
     */
    protected $annotationProvider;

    /**
     * @var ParametersProcessorInterface
     */
    protected $noOpParametersProcessor;

    public function __construct(
        AnnotationProvider $annotationProvider,
        ParametersProcessorInterface $noOpParametersProcessor
    ) {
        $this->annotationProvider = $annotationProvider;
        $this->noOpParametersProcessor = $noOpParametersProcessor;
    }

    protected function getNoOpParametersProcessor(): ParametersProcessorInterface
    {
        return $this->noOpParametersProcessor;
    }

    protected function getAnnotationProvider(): AnnotationProvider
    {
        return $this->annotationProvider;
    }
}
