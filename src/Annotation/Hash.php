<?php

namespace Pgs\HashIdBundle\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Hash
{
    private $parameters = [];

    public function __construct(array $parameters)
    {
        if (isset($parameters['value']) && is_array($parameters['value'])) {
            $parameters = $parameters['value'];
        }

        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }
}
