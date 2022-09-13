<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Servicios extends Model
{
    use HasFactory;

    protected $fillable = [
        'cuarto_id',
        'tipo_ingreso',
        'placa_vehiculo',
        'horas_servicio',
        'hora_ingreso',
        'hora_salida',
        'tipo_pago',
        'precio',
        'estado'
    ];

    public function cuarto(){
        return $this->belongsTo(Cuartos::class, 'cuarto_id');
    }
}
