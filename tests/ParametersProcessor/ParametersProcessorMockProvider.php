<?php

namespace Pgs\HashIdBundle\Tests\ParametersProcessor;

use PHPUnit\Framework\TestCase;

class ParametersProcessorMockProvider extends TestCase
{
    public function getParametersProcessorMock($class)
    {
        $mock = $this
            ->getMockBuilder($class)
            ->disableOriginalConstructor()
            ->setMethods(['setParametersToProcess', 'process', 'needToProcess'])
            ->getMock();

        $mock->method('setParametersToProcess')->willReturnSelf();

        return $mock;
    }
}
