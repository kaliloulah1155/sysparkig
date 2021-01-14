<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Tarifa extends Model
{
     protected $table="tarifas"  ;

     protected $fillable=['tiempo','description','costo','jerarquia','tipo_id'];
}
