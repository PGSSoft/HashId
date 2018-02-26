<?php


namespace Pgs\HashIdBundle\ParametersProcessor;


use Hashids\HashidsInterface;

abstract class AbstractParametersProcessor implements ParametersProcessorInterface
{
    protected $parametersToProcess = [];

    /**
     * @var HashidsInterface
     */
    protected $hashIds;

    public function __construct(HashidsInterface $hashIds, array $parametersToProcess = [])
    {
        $this->hashIds = $hashIds;
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

    public function getHashIds(): HashidsInterface
    {
        return $this->hashIds;
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

    abstract protected function processValue($value);
}