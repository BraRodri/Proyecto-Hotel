<?php

namespace App\View\Components\Cuartos;

use App\Helper\Helper;
use App\Models\TipoServicios;
use Illuminate\View\Component;

class CrearCuarto extends Component
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
        $estados = Helper::getDataEstadosCuartos();
        $tipos_servicios = TipoServicios::where('estado', 1)->get();
        return view('components.cuartos.crear-cuarto', compact('estados', 'tipos_servicios'));
    }
}
