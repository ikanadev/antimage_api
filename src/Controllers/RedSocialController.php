<?php
namespace Controllers;

use \Models\Response as Res;
use \Models\Utils;
use \Models\RedSocial;

class RedSocialController
{
  public static function update($admin, $data) {
    $redSocial = RedSocial::find($data['id']);
    if (!$redSocial) {
      return Res::InternarServerError('Error al buscar la red social con id ' . $data['id']);
    }
    $redSocial->update($data['datos']);
    return Res::OKWhitToken(
      'todo ok',
      'Información de red social actulizada',
      Utils::generateToken($admin->id, $admin->correo),
      $redSocial
    );
  }
  public static function list($admin) {
    $socials = RedSocial::all();
    return Res::OKWhitToken(
      'todo ok',
      'Información de contacto cargada',
      Utils::generateToken($admin->id, $admin->correo),
      $socials
    );
  }
}
