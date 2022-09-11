<?php

namespace App\View\Components\Servicios;

use App\Helper\Helper;
use App\Models\Cuartos;
use Illuminate\View\Component;

class CrearServicio extends Component
{
    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        $cuartos = Cuartos::where('estado', 1)->get();
        $tipos_ingresos = Helper::getDataTiposIngresos();
        $estados = Helper::getDataEstadoServicios();
        $horas_servicio = Helper::getDataHorasServicio();
        return view('components.servicios.crear-servicio', compact('cuartos', 'tipos_ingresos', 'estados', 'horas_servicio'));
    }
}
