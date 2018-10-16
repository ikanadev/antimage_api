<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $guarded = [];
    protected $table = 'menu';
    protected $hidden = ['carrera_id'];
    public $timestamps = false;

    public function submenus()
    {
        return $this->hasMany('\Models\SubMenu');
    }
}
