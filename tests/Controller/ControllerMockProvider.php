<?php

namespace Pgs\HashIdBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ControllerMockProvider extends TestCase
{
    public function getTestControllerMock(): Controller
    {
        return $this->getMockBuilder(Controller::class)
            ->getMockForAbstractClass();
    }
}
