<?php
namespace Controllers;

use \Models\Response as Res;
use \Models\Utils;
use \Models\EnlaceExterno;

class EnlaceExternoController
{
  public static function add($admin, $data) {
    $carrera = Utils::getCarrer();
    $data['carrera_id'] = $carrera->id;
    $enlace = EnlaceExterno::create($data);
    if (!$enlace) {
      return Res::InternarServerError('Error al crear enlace');
    }
    return Res::OKWhitToken(
      'todo ok',
      'Nuevo enlace externo creado',
      Utils::generateToken($admin->id, $admin->correo),
      $enlace
    );
  }
  public static function update($admin, $data) {
    $enlace = EnlaceExterno::find($data['id']);
    if (!$enlace) {
      return Res::InternarServerError('Error al buscar el enlaceExterno con id ' . $data['id']);
    }
    $enlace->update($data['datos']);
    return Res::OKWhitToken(
      'todo ok',
      'Información de enlace externo actulizada',
      Utils::generateToken($admin->id, $admin->correo),
      $enlace
    );
  }
  public static function list($admin) {
    $lista = EnlaceExterno::all();
    return Res::OKWhitToken(
      'todo ok',
      'Lista Obtenida',
      Utils::generateToken($admin->id, $admin->correo),
      $lista
    );
  }
  public static function delete($admin, $data) {
    $deleted = EnlaceExterno::destroy($data['id']);
    return Res::OKWhitToken(
      'todo ok',
      'Información de enlace externo actulizada',
      Utils::generateToken($admin->id, $admin->correo),
      $data['id']
    );
  }
}
