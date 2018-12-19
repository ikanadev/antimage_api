<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class RedSocial extends Model
{
  protected $guarded = [];
  protected $table   = 'redSocial';
  protected $hidden  = ['carrera_id'];
  public $timestamps = false;
  protected $casts   = [
    'habilitado' => 'boolean'
  ];
}
