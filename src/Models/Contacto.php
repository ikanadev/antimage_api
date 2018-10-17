<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Contacto extends Model
{
    protected $guarded = [];
    protected $table = 'contacto';
    protected $hidden = ['carrera_id'];
    public $timestamps = false;
}
