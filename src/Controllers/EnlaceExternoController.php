<?php
namespace Controllers;

use \Models\Response as Res;
use \Models\Utils;
use \Models\EnlaceExterno;

class EnlaceExternoController
{
    public static function Add($admin, $data)
    {
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
    public static function Update($admin, $data)
    {
        $enlace = EnlaceExterno::find($data['id']);
        if (!$enlace) {
            return Res::InternarServerError('Error al buscar el enlaceExterno con id '.$data['id']);
        }
        $enlace->update($data['datos']);
        return Res::OKWhitToken(
            'todo ok',
            'Información de enlace externo actulizada',
            Utils::generateToken($admin->id, $admin->correo),
            $enlace
        );
    }
    /* public static function Delete($admin, $data)
    {
        $deleted = ::destroy($data['id']);
        return Res::OKWhitToken(
            'todo ok',
            'Información de contacto borrada',
            Utils::generateToken($admin->id, $admin->correo),
            $deleted
        );
    }
    /* public static function List($admin)
    {
        $contacts = Contacto::all();
        return Res::OKWhitToken(
            'todo ok',
            'Información de contacto cargada',
            Utils::generateToken($admin->id, $admin->correo),
            $contacts
        );
    } */
}
