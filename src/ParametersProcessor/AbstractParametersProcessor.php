<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor;

use Pgs\HashIdBundle\ParametersProcessor\Converter\ConverterInterface;

abstract class AbstractParametersProcessor implements ParametersProcessorInterface
{
    protected $parametersToProcess = [];

    /**
     * @var ConverterInterface
     */
    protected $converter;

    public function __construct(ConverterInterface $converter, array $parametersToProcess = [])
    {
        $this->converter = $converter;
        $this->parametersToProcess = $parametersToProcess;
    }

    public function setParametersToProcess(array $parametersToProcess): ParametersProcessorInterface
    {
        $this->parametersToProcess = $parametersToProcess;

        return $this;
    }

    public function getParametersToProcess(): array
    {
        return $this->parametersToProcess;
    }

    public function getConverter(): ConverterInterface
    {
        return $this->converter;
    }

    public function process(array $parameters): array
    {
        foreach ($this->getParametersToProcess() as $parameter) {
            if (isset($parameters[$parameter])) {
                $parameters[$parameter] = $this->processValue($parameters[$parameter]);
            }
        }

        return $parameters;
    }

    public function needToProcess(): bool
    {
        return \count($this->getParametersToProcess()) > 0;
    }

    abstract protected function processValue($value);
}
