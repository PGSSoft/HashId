<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor\Converter;

use Hashids\HashidsInterface;

class HashidsConverter implements ConverterInterface
{
    /**
     * @var HashidsInterface
     */
    private $hashids;

    public function __construct(HashidsInterface $hashids)
    {
        $this->hashids = $hashids;
    }

    public function encode($value): string
    {
        return $this->hashids->encode($value);
    }

    public function decode($value)
    {
        $result = $this->hashids->decode($value);

        return $result[0] ?? $value;
    }
}
