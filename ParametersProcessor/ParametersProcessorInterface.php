<?php


namespace Pgs\HashIdBundle\ParametersProcessor;


interface ParametersProcessorInterface
{
    public function process(array $parameters): array;

    public function setParametersToProcess(array $parametersToProcess): ParametersProcessorInterface;

    public function getParametersToProcess(): array;
}