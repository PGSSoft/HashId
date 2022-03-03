<?php

namespace Pgs\HashIdBundle\Tests\Controller;

use Pgs\HashIdBundle\Annotation\Hash;
use Symfony\Component\Routing\Annotation\Route;

class ParamsAnnotatedController
{
    /**
     * @Route("/{enroll}", name="test_route")
     * @Hash('toDecode')
     */
    public function getArticlesAction($toDecode = null)
    {
    }

    #[Route('/{toDecode}', name: 'test_route')]
    #[Hash('toDecode')]
    public function getArticlesAttributesAction($toDecode = null)
    {
    }

    public function __invoke()
    {
        
    }
}