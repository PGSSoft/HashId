<?php


namespace Pgs\HashIdBundle\Controller;


use Pgs\HashIdBundle\Annotation\Hash;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DemoController extends Controller
{
    public function encode($id)
    {
        $other = 30;
        $url1 = $this->generateUrl('pgs_hash_id_demo_decode', ['id' => $id, 'other' => $other]);
        $url2 = $this->generateUrl('pgs_hash_id_demo_decode_more', ['id' => $id, 'other' => $other]);

        $response = <<<EOT
            <html>
                <body>
                Provided id: $id, other: $other <br />
                Url with encoded parameter: <a href="$url1">$url1</a><br />
                Another url with encoded more parameters: <a href="$url2">$url2</a><br />
                </body>
            </html>
EOT;
        return new Response($response);
    }

    /**
     * @Hash("id")
     */
    public function decode(Request $request, int $id, int $other)
    {
        return new Response($this->getDecodeResponse($request, $id, $other));
    }

    /**
     * @Hash({"id", "other"})
     */
    public function decodeMore(Request $request, int $id, int $other)
    {
        return new Response($this->getDecodeResponse($request, $id, $other));
    }

    private function getDecodeResponse(Request $request, int $id, int $other)
    {
        $providedId = $this->getRouteParam($request, 'id');
        $providedOther = $this->getRouteParam($request, 'other');

        $response = <<<EOT
            <html>
                <body>
                Provided id: <b>$providedId</b>, other: <b>$providedOther</b><br />
                Decoded id: <b>$id</b>, other: <b>$other</b><br />
                </body>
            </html>
EOT;
        return $response;
    }

    private function getRouteParam(Request $request, $param)
    {
        return $request->attributes->get('_route_params')[$param];
    }
}