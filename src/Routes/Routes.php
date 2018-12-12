<?php
use \Controllers\AdminController as AC;
use \Controllers\CarrerController as CarrerC;
use \Controllers\ContactoController as ContactC;
use \Controllers\MenuController as MenuC;
use \Controllers\RedSocialController as RedSocialC;
use \Controllers\EnlaceExternoController as EExternoC;
use \Controllers\CarouselController as CarouselC;
use \Models\Utils;
use \Middlewares\AdminAuth;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app->get(
  '/', 
  function (Request $req, Response $res) {
    return $res->withJson(password_hash('egamitna', PASSWORD_DEFAULT));
  }
);
$app->group(
  '/writer',
  function () use ($app) {
    // para registrar a un nuevo publicador
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = AC::AddWriter($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );

    // para que un publicador pueda modificar su perfil si lo envia un
    // admin, mandar 'id, nombres, correo, password, apellidos'
    // si envia un writer, mandar el id de si mismo (actulizar datos)
    // 'id, nombres, apellidos y password'
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = AC::UpdateWriter($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());

$app->group(
  '/admin',
  function () use ($app) {
    // actualizar los datos del administrador 'nombres, apellidos password y correo'
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = AC::UpdateAdmin($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/carrer',
  function () use ($app) {
    // actualizar los datos de la carrera 'nombre, descripcion y urlLogo'
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $file   = count($req->getUploadedFiles()) == 0 ? null : $req->getUploadedFiles()['urlLogo'];
        $admin  = $req->getAttribute('admin');
        $result = CarrerC::Update($admin, $file, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/menu',
  function () use ($app) {
    // Registrar nuevo menu, solo enviar 'nombre'
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = MenuC::Add($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    // Actualizar un menu: { id: 2, datos: {nombre*: '', estado*: [1,0]}}
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = MenuC::Update($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    // Registrar nuevo menu, envia 'nombre, menuId y tipo ['posts, page']'
    $app->post(
      '/submenu',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = MenuC::AddSubmenu($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    // Actulizar un Submenu: { id: 2(del submenu), datos: {nombre*: '', estado*: [1,0]}}
    $app->put(
      '/submenu',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = MenuC::UpdateSubmenu($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    // List of menus.
    $app->get(
      '/', 
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = MenuC::list($admin);
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/contact',
  function () use ($app) {
    // nuevo contacto
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = ContactC::Add($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = ContactC::Update($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->delete(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = ContactC::Delete($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->get(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = ContactC::list($admin);
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/social',
  function () use ($app) {
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = RedSocialC::Update($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->get(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = RedSocialC::list($admin);
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/link',
  function () use ($app) {
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = EExternoC::Add($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->put(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = EExternoC::Update($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->group(
  '/carousel',
  function () use ($app) {
    $app->post(
      '/',
      function (Request $req, Response $res) {
        $file   = count($req->getUploadedFiles()) == 0 ? null : $req->getUploadedFiles()['urlImg'];
        $admin  = $req->getAttribute('admin');
        $result = CarouselC::Add($admin, $file, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->post(
      '/update',
      function (Request $req, Response $res) {
        $file   = count($req->getUploadedFiles()) == 0 ? null : $req->getUploadedFiles()['urlImg'];
        $admin  = $req->getAttribute('admin');
        $result = CarouselC::Update($admin, $file, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->delete(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = CarouselC::Delete($admin, $req->getParsedBody());
        return $res->withJson($result);
      }
    );
    $app->get(
      '/',
      function (Request $req, Response $res) {
        $admin  = $req->getAttribute('admin');
        $result = CarouselC::list($admin);
        return $res->withJson($result);
      }
    );
  }
)->add(new AdminAuth());
$app->post(
  '/login',
  function (Request $req, Response $res) {
    $result = AC::Login($req->getParsedBody());
    return $res->withJson($result);
  }
);
$app->post(
  '/file',
  function (Request $req, Response $res) {
    $file = count($req->getUploadedFiles()) == 0 ? null : $req->getUploadedFiles()['img'];
    if (!$file) {
      return $res->withJson(['url' => 'No se pudo leer los archivos']);
    }
    $path       = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img';
    $protocol   = stripos($_SERVER['SERVER_PROTOCOL'], 'https') === true ? 'https://' : 'http://';
    $serverName = $protocol . IP . DIRECTORY_SEPARATOR . PROJECTNAME . $path . DIRECTORY_SEPARATOR;
    $urlImg     = $serverName . Utils::moveUploadedFile(PROJECTPATH . $path, $file);

    return $res->withJson(['url' => $urlImg]);
  }
);
