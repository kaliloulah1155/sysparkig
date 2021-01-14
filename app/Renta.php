<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Renta extends Model
{
    protected $table="rentas";
    protected $fillable=[
    	'acceso',
    	'salida',
    	'placa',
    	'modelo',
    	'marca',
    	'color',
    	'llaves',
    	'total',
    	'effectivo',
    	'cambio',
    	'user_id',
    	'vehiculo_id',
    	'tarifa_id',
    	'barcode',
    	'estatus',
    ];
}
