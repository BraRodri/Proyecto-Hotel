<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuartos extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo_servicio_id',
        'precio',
        'estado'
    ];

    public function tipoServicios(){
        return $this->belongsTo(TipoServicios::class, 'tipo_servicio_id');
    }
}
