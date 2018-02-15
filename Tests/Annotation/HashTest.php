<?php


namespace Pgs\HashIdBundle\Tests\Annotation;

use Pgs\HashIdBundle\Annotation\Hash;
use PHPUnit\Framework\TestCase;


class HashTest extends TestCase
{
    public function testGetParameters()
    {
        $parameters = ['id'];
        $hash = new Hash($parameters);
        $this->assertSame(['id'], $hash->getParameters());
    }
}