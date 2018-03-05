<?php


namespace Pgs\HashIdBundle\Tests\Route;


use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Route;

class RouteMockProvider extends TestCase
{
    public function getTestRouteMock()
    {
        $mock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDefault'])
            ->getMock();
        $mock->method('getDefault')->with('_controller')->willReturn('TestController::testMethod');

        return $mock;
    }

    public function getInvalidRouteMock()
    {
        $mock = $this->getMockBuilder(Route::class)
            ->disableOriginalConstructor()
            ->setMethods(['getDefault'])
            ->getMock();
        $mock->method('getDefault')->with('_controller')->willReturn('bad_controller_string');

        return $mock;
    }
}