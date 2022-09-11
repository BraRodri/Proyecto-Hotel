<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Facturas extends Model
{
    use HasFactory;

    protected $fillable = [
        'servicio_id',
        'cuarto',
        'tipo_ingreso',
        'placa_vehiculo',
        'horas_servicio',
        'hora_ingreso',
        'hora_salida',
        'precio'
    ];
}
