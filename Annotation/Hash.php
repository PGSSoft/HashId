<?php


namespace Pgs\HashIdBundle\Annotation;


/**
 * @Annotation
 * @Target({"METHOD"})
 *
 */
class Hash
{

    private $parameters = [];

    public function __construct(array $parameters)
    {
        $this->parameters = $parameters;
    }

    public function getParameters(): array
    {
        return $this->parameters;
    }

}