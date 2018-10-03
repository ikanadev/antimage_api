<?php
use \Controllers\AdminController as AC;
use \Middlewares\AdminAuth;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get('/', function (Request $req, Response $res) {
    return $res->withJson(password_hash('egamitna', PASSWORD_DEFAULT));
});
$app->group('/writer', function () use ($app) {
    // para registrar a un nuevo publicador
    $app->post('/', function (Request $req, Response $res) {
        $admin = $req->getAttribute('admin');
        $result = AC::AddWriter($admin, $req->getParsedBody());
        return $res->withJson($result);
    });
    // para que un publicador pueda modificar su perfil si lo envia un 
    // admin, mandar 'id, nombres, correo, password, apellidos'
    // si envia un writer, mandar el id de si mismo (actulizar datos) 
    // 'id, nombres, apellidos y password'
    $app->put('/', function (Request $req, Response $res) {
        $admin = $req->getAttribute('admin');
        $result = AC::UpdateWriter($admin, $req->getParsedBody());
        return $res->withJson($result);
    });
})->add(new AdminAuth());
$app->group('/admin', function () use ($app) {
    // actualizar los datos del administrador 'nombres, apellidos password y correo'
    $app->put('/', function (Request $req, Response $res) {
        $admin = $req->getAttribute('admin');
        $result = AC::UpdateAdmin($admin, $req->getParsedBody());
        return $res->withJson($result);
    });
})->add(new AdminAuth());
$app->post('/login', function (Request $req, Response $res) {
    $result = AC::Login($req->getParsedBody());
    return $res->withJson($result);
});
