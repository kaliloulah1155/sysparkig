<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cajon extends Model
{
    //

     protected $table="cajones"  ;

     protected $fillable=['description','tipo_id','estatus'];

     //relation cajones an tipos

     
}
