<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class EnlaceExterno extends Model
{
    protected $guarded = [];
    protected $table = 'enlaceExterno';
    protected $hidden = ['carrera_id'];
    public $timestamps = false;
}
