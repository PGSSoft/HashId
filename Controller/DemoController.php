<?php


namespace Pgs\HashIdBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends Controller
{
    /**
     * @Route("/hash-id/demo/{id}", name="pgs_hash_id_demo")
     */
    public function demo($id)
    {
        $this->generateUrl('pgs_hash_id_demo', ['id' => $id]);
        return new Response(
            '<html><body>Provided id: '.$id.'</body></html>'
        );
    }
}