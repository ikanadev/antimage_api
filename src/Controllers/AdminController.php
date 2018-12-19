<?php
namespace Controllers;

use \Models\Admin;
use \Models\Response as Res;
use \Models\Utils;

class AdminController
{
  public static function list($admin) {
    $list = Admin::where('tipo', 'writer')->get();
    return Res::OKWhitToken(
      'OK',
      'lista de writers cargada ',
      Utils::generateToken($admin->id, $admin->correo),
      $list
    );
  }
  public static function delete($admin, $data) {
    Admin::destroy($data['id']);
    return Res::OKWhitToken(
      'OK',
      'borrado un admin ',
      Utils::generateToken($admin->id, $admin->correo),
      ['id' => $data['id']]
    );
  }
  public static function addWriter($admin, $data) {
    $existAdmin = Admin::where('correo', $data['correo'])->first();
    if ($existAdmin) {
      return Res::Conflict('Correo ya registrado', 'El correo ingresado ya esta siendo utilizado.');
    }
    $newAdmin = Admin::create(
      [
        'nombres' => $data['nombres'],
        'apellidos' => $data['apellidos'],
        'password' => password_hash($data['password'], PASSWORD_DEFAULT),
        'correo' => $data['correo'],
        'tipo' => 'writer'
      ]
    );
    if (!$newAdmin) {
      return Res::InternarServerError('Fallo al crear Escritor');
    }
    return Res::OKWhitToken(
      'Se creo el admin ' . $newAdmin->nombres . '  con id ' . $newAdmin->id,
      'Se creo el administrador ' . $newAdmin->nombres . ' con permisos para publicar ',
      Utils::generateToken($admin->id, $admin->correo),
      $newAdmin
    );
  }

  public static function login($data) {
    $admin = Admin::where('correo', $data['correo'])->first();
    if (!$admin) {
      return Res::Unauthorized(
        'Correo no encontrado.',
        'Verifique sus datos e intente nuevamente.'
      );
    }
    if (!password_verify($data['password'], $admin->password)) {
      return Res::Unauthorized(
        'password inválido.',
        'Verifique sus datos e intente nuevamente.'
      );
    }
    $tokenstr = Utils::generateToken($admin->id, $admin->correo);
    $hora = (int)date('G');
    $saludo = '';
    if ($hora <= 12) {
      $saludo = 'Buenos días ';
    } else {
      $saludo = $hora <= 18 ? 'Buenas tardes ' : 'Buenas Noches';
    }
    $data = [
      'admin' => $admin,
      'carrer' => Utils::getCarrerWithProtocol()
    ];
    return Res::OKWhitToken(
      'Login correcto',
      $saludo . $admin->nombres,
      $tokenstr,
      $data
    );
  }

  public static function updateWriter($admin, $data) {
    $writer = Admin::find($data['id']);
    if (!$writer) {
      return Res::InternarServerError('admin no encontrado');
    }
    if ($data['datos']['password'] == '') {
      $data['datos']['password'] = $writer->password;
    } else {
      $data['datos']['password'] = password_hash($data['datos']['password'], PASSWORD_DEFAULT);
    }
    $writer->update($data['datos']);
    return Res::OKWhitToken(
      'Datos modificados del admin con id: ' . $writer->id,
      'Datos actualizados correctamente.',
      Utils::generateToken($admin->id, $admin->correo),
      $writer
    );
  }

  public static function updateAdmin($admin, $data) {
    $exist = Admin::where('correo', $data['correo'])->first();
    if ($exist && $exist->tipo == 'writer') {
      return Res::Conflict('Ya existe un escritor', 'El correo ya esta siendo usado');
    }
    if ($data['password'] == '') {
      $data['password'] = $admin->password;
    } else {
      $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
    }
    $admin->update($data);
    return Res::OKWhitToken(
      'Datos del admin actualizado',
      'Datos actualizados correctamente.',
      Utils::generateToken($admin->id, $admin->correo),
      $admin
    );
  }
}
