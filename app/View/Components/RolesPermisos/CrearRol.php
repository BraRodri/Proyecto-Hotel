<?php

namespace App\View\Components\RolesPermisos;

use App\Helper\Helper;
use Illuminate\View\Component;
use Spatie\Permission\Models\Permission;

class CrearRol extends Component
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
        $permisos = Permission::all();
        return view('components.roles-permisos.crear-rol', compact('permisos'));
    }
}
