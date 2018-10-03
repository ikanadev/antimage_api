<?php
namespace Middlewares;

use \Models\Admin;
use \Models\Response as Res;
use \Models\Utils;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

class AdminAuth
{
    public function __invoke(Request $req, Response $res, $next)
    {
        $tokenarr = $req->getHeader('Authorization');
        if (count($tokenarr) == 0) {
            $respuesta = Res::BadRequest('No se reconoce el token en los headers.');
            return $res->withJson($respuesta);
        }
        $data = Utils::decodeToken($tokenarr[0]);
        if ($data == false) {
            $response = Res::Unauthorized(
                'Token expirado.',
                'Ha estado inactivo por un largo tiempo, por favor ingrese de nuevo'
            );
            return $res->withJson($response);
        }
        //var_dump($next['logger']);
        $admin = Admin::Where('correo', $data['correo'])->first();
        if (!$admin) {
            $response = Res::InternarServerError('Error identificando el token');
        }
        $req = $req->withAttribute('admin', $admin);
        $res = $next($req, $res);
        // HERE GOES THE ACTIONS AFTER THE REQUEST
        return $res;
    }
}
