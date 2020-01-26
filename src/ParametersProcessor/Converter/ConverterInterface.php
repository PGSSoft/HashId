<?php

declare(strict_types=1);

namespace Pgs\HashIdBundle\ParametersProcessor\Converter;

interface ConverterInterface
{
    public function encode($value): string;

    public function decode($value);
}
