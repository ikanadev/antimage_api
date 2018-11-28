<?php
namespace Controllers;

use \Models\Carousel;
use \Models\Response as Res;
use \Models\Utils;

class CarouselController
{
    public static function Add($admin, $file, $data)
    {
        if (!$file) {
            return Res::InternarServerError('No se reconoce el archivo enviado');
        }
        $carrer = Utils::getCarrer();
        $path = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img';
        $serverName = IP . DIRECTORY_SEPARATOR . PROJECTNAME . $path . DIRECTORY_SEPARATOR;
        $data['urlImg'] = $serverName . Utils::moveUploadedFile(PROJECTPATH . $path, $file);
        $data['carrera_id'] = $carrer->id;
        $carousel = Carousel::create($data);
        if (!$carousel) {
            return Res::InternarServerError('No se pudo crear el carousel');
        }
        $carousel->urlImg = Utils::withProtocol($carousel->urlImg);
        return Res::OKWhitToken(
            'Carousel creado',
            'Datos Guardados.',
            Utils::generateToken($admin->id, $admin->correo),
            $carousel
        );
    }
    public static function Update($admin, $file, $data)
    {
        if ($file) {
            $path = DIRECTORY_SEPARATOR . 'public' . DIRECTORY_SEPARATOR . 'img';
            $serverName = IP . DIRECTORY_SEPARATOR . PROJECTNAME . $path . DIRECTORY_SEPARATOR;
            $data['urlImg'] = $serverName . Utils::moveUploadedFile(PROJECTPATH . $path, $file);
        }
        $carousel = Carousel::find($data['id']);
        if (!$carousel) {
            return Res::InternarServerError('No se pudo encontrar el carousel con ID: ' . $data['id']);
        }
        $carousel->update($data);
        return Res::OKWhitToken(
            'Carousel actualizado',
            'Carousel Actulizado.',
            Utils::generateToken($admin->id, $admin->correo),
            $carousel
        );
    }
    public static function Delete($admin, $data)
    {
        $deleted = Carousel::destroy($data['id']);
        return Res::OKWhitToken(
            'Carousel Eliminado',
            'Carousel Eliminado.',
            Utils::generateToken($admin->id, $admin->correo),
            $deleted
        );
    }
    public static function List($admin) {
        $carousels = Carousel::all();
        $carousels = $carousels->map(function ($carousel) {
            $carousel->urlImg = Utils::withProtocol($carousel->urlImg);
            return $carousel;
        });
        return Res::OKWhitToken(
            'Lista obtenida',
            'Lista Cargada',
            Utils::generateToken($admin->id, $admin->correo),
            $carousels
        );
    }
}
