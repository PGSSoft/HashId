<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor;

class NoOp implements ParametersProcessorInterface
{
    protected $parametersToProcess = [];

    public function process(array $parameters): array
    {
        return $parameters;
    }

    public function getParametersToProcess(): array
    {
        return [];
    }

    public function setParametersToProcess(array $parametersToProcess): ParametersProcessorInterface
    {
        $this->parametersToProcess = [];

        return $this;
    }

    public function needToProcess(): bool
    {
        return false;
    }
}
