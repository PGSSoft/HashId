<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor;

use Pgs\HashIdBundle\ParametersProcessor\Converter\ConverterInterface;
use Psr\Log\LoggerInterface;

abstract class AbstractParametersProcessor implements ParametersProcessorInterface
{
    protected $parametersToProcess = [];

    /**
     * @var ConverterInterface
     */
    protected $converter;

    /**
     * @var LoggerInterface
     */
    protected $logger;

    public function __construct(
        ConverterInterface $converter,
        LoggerInterface $logger,
        array $parametersToProcess = []
    ) {
        $this->converter = $converter;
        $this->logger = $logger;
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

    protected function getLogger(): LoggerInterface
    {
        return $this->logger;
    }

    public function process(array $parameters): array
    {
        $this->getLogger()->info(
            sprintf('Attempt to process "%s" parameters', implode(',', $this->getParametersToProcess()))
        );
        foreach ($this->getParametersToProcess() as $parameter) {
            if (isset($parameters[$parameter])) {
                $processedValue = $this->processValue($parameters[$parameter]);
                $this->getLogger()->info(
                    sprintf('Processing "%s" parameter: %s => %s', $parameter, $parameters[$parameter], $processedValue)
                );
                $parameters[$parameter] = $processedValue;
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
