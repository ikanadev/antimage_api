<?php
namespace Controllers;

use \Models\Menu;
use \Models\SubMenu;
use \Models\Response as Res;
use \Models\Utils;

class MenuController
{
    // @Add Funcion para adicionar un nuevo menu
    public static function Add($admin, $data)
    {
        $carrera = Utils::getCarrer();
        $menu = Menu::create([
            'carrera_id' => $carrera->id,
            'nombre' => $data['nombre'],
            'estado' => 1,
        ]);
        if (!$menu) {
            return Res::InternarServerError('Fallo al crear el Menu');
        }
        return Res::OKWhitToken(
            'Menu creado, id: ' . $menu->id,
            'Menu creado correctamente',
            Utils::generateToken($admin->id, $admin->correo),
            $menu
        );
    }
    // Actualizar un menu creado, se puede modificar tanto el nombre como el estado.
    public static function Update($admin, $data)
    {
        $carrera = Utils::getCarrer();
        $menu = Menu::find($data['id']);
        if (!$menu) {
            return Res::InternarServerError('Fallo al encontrar el menu con ID: ' . $data['id']);
        }
        $menu->update($data['datos']);
        return Res::OKWhitToken(
            'Todo OK',
            'Menu actualizado',
            Utils::generateToken($admin->id, $admin->correo),
            $menu
        );
    }
    // nuevo sub Menu, enviar menuId, y nombre
    public static function AddSubmenu($admin, $data)
    {
        $carrera = Utils::getCarrer();
        $subMenu = SubMenu::create([
            'menu_id'   => $data['menuId'],
            'nombre'    => $data['nombre'],
            'tipo'      => $data['tipo'],
            'estado'    => 1
        ]);
        if (!$subMenu) {
            return Res::InternarServerError('Fallo al crear el SubMenu');
        }
        return Res::OKWhitToken(
            'sub menu creado, id: ' . $subMenu->id,
            'Submenu creado correctamente',
            Utils::generateToken($admin->id, $admin->correo),
            $subMenu
        );
    }
    // Update submenu
    public static function UpdateSubmenu($admin, $data)
    {
        $carrera = Utils::getCarrer();
        $subMenu = SubMenu::find($data['id']);
        if (!$subMenu) {
            return Res::InternarServerError('Fallo al encontrar el SubMenu con id: '. $data['id']);
        }
        $subMenu->update($data['datos']);
        return Res::OKWhitToken(
            'Todo OK',
            'SubMenu actualizado',
            Utils::generateToken($admin->id, $admin->correo),
            $subMenu
        );
    }
    // returns a list of menu with his submenu
    public static function List($admin)
    {
        $carrera = Utils::getCarrer();
        $menus = Menu::with(['submenus'])->get();
        return Res::OKWhitToken(
            'Todo OK',
            'Menu cargado',
            Utils::generateToken($admin->id, $admin->correo),
            $menus
        );
    }
}
