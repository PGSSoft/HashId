<?php


namespace Pgs\HashIdBundle\Controller;


use Pgs\HashIdBundle\Annotation\Hash;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class DemoController extends Controller
{
    public function encode($id)
    {
        $url = $this->generateUrl('pgs_hash_id_demo_decode', ['id' => $id]);

        return new Response(
            '<html><body>Provided id: '.$id.'<br />url: '.$url.'</body></html>'
        );
    }

    /**
     * @Hash("id")
     */
    public function decode($id)
    {
        return new Response(
            '<html><body>Decoded id: '.$id.'<br /></body></html>'
        );
    }
}