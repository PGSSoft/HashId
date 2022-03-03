<?php

namespace Pgs\HashIdBundle\Tests\Controller;

use PHPUnit\Framework\TestCase;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ControllerMockProvider extends TestCase
{
    public function getTestControllerMock(): AbstractController
    {
        return $this->getMockBuilder(AbstractController::class)
            ->getMockForAbstractClass();
    }

    public function getTestControllerObjectMock(): AbstractController
    {
        return $this->getMockBuilder(AbstractController::class)
            ->setMethods(['__invoke'])
            ->getMockForAbstractClass();
    }
}
