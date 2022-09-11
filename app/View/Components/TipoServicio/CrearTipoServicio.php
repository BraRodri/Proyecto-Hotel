<?php

namespace App\View\Components\TipoServicio;

use App\Helper\Helper;
use Illuminate\View\Component;

class CrearTipoServicio extends Component
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
        $estados = Helper::getDataTipoServicio();
        return view('components.tipo-servicio.crear-tipo-servicio', compact('estados'));
    }
}
