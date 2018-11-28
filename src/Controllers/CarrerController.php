<?php
namespace Controllers;

use \Models\Response as Res;
use \Models\Utils;

class CarrerController
{
    public static function Update($admin, $file, $data)
    {
        if ($file) {
            $path = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img';
            $serverName = IP . DIRECTORY_SEPARATOR . PROJECTNAME . $path . DIRECTORY_SEPARATOR;
            $data['urlLogo'] = $serverName . Utils::moveUploadedFile(PROJECTPATH . $path, $file);
        }
        $carrer = Utils::getCarrer();
        $carrer->update($data);
        $carrer = Utils::getCarrerWithProtocol();
        //return $carrer;
        $data = [
            'admin' => $admin,
            'carrer' => $carrer,
        ];
        return Res::OKWhitToken(
            'Login correcto',
            'Datos de la carrera actualizados correctamente',
            Utils::generateToken($admin->id, $admin->correo),
            $data
        );
    }
}
