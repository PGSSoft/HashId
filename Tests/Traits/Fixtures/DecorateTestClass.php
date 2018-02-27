<?php


namespace Pgs\HashIdBundle\Tests\Traits\Fixtures;


use Pgs\HashIdBundle\Traits\DecoratorTrait;

class DecorateTestClass
{
    use DecoratorTrait;

    public function __construct($object)
    {
        $this->object = $object;
    }
}