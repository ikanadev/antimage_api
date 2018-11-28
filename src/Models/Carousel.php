<?php
namespace Models;

use Illuminate\Database\Eloquent\Model;

class Carousel extends Model
{
    protected $guarded = [];
    protected $table = 'carousel';
    public $timestamps = false;
    protected $hidden = ['carrera_id'];
}
