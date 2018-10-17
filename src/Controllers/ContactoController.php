<?php
namespace Controllers;

use \Models\Response as Res;
use \Models\Utils;
use \Models\Contacto;

class ContactoController
{
    public static function Add($admin, $data)
    {
        $carrera = Utils::getCarrer();
        $data['carrera_id'] = $carrera->id;
        $contacto = Contacto::create($data);
        if (!$contacto) {
            return Res::InternarServerError('error al crear contacto');
        }
        return Res::OKWhitToken(
            'todo ok',
            'Nueva información de contacto creada',
            Utils::generateToken($admin->id, $admin->correo),
            $contacto
        );
    }
    public static function Update($admin, $data)
    {
        $contacto = Contacto::find($data['id']);
        if (!$contacto) {
            return Res::InternarServerError('Error al buscar el contacto con id '.$data['id']);
        }
        $contacto->update($data['datos']);
        return Res::OKWhitToken(
            'todo ok',
            'Información de contacto actulizada',
            Utils::generateToken($admin->id, $admin->correo),
            $contacto
        );
    }
    public static function Delete($admin, $data)
    {
        $deleted = Contacto::destroy($data['id']);
        return Res::OKWhitToken(
            'todo ok',
            'Información de contacto borrada',
            Utils::generateToken($admin->id, $admin->correo),
            $deleted
        );
    }
    public static function List($admin)
    {
        $contacts = Contacto::all();
        return Res::OKWhitToken(
            'todo ok',
            'Información de contacto cargada',
            Utils::generateToken($admin->id, $admin->correo),
            $contacts
        );
    }
}
