<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    protected $guarded = [];
    protected $table = 'submenu';
    protected $hidden = ['menu_id'];
    public $timestamps = false;
}
