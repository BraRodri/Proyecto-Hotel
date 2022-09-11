<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\TipoServicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TipoServiciosController extends Controller
{

    public function index()
    {
        return view('pages.tipos_servicios.index');
    }

    public function all()
    {
        $datos = array();

        $data = TipoServicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                if(Auth::user()->can('Editar Tipos Servicios')){
                    $botones .= "<a href='".route('tipos_servicios.edit', $value->id)."' class='btn btn-success btn-sm'><i class='fa-solid fa-pen'></i> Editar</a>";
                }
                if(Auth::user()->can('Eliminar Tipos Servicios')){
                    $botones .= "<button onclick='eliminar(".$value->id.");' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i> Eliminar</button>";
                }
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->nombre,
                    "<span class='badge bg-" . Helper::getColorEstadoUser($value->estado) . "'>" . Helper::getEstadoTipoServicio($value->estado) . "</span>",
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function create(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = TipoServicios::where('nombre', $request->nombre)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya existe un tipo de servicio con el nombre que esta ingresando, intente con otro!';
        } else {

            $crear = array(
                'nombre' => $request->nombre,
                'estado' => $request->estado
            );

            if(TipoServicios::create($crear)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al crear al tipo de servicio!';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $info = TipoServicios::findOrFail($id);
        $estados = Helper::getDataTipoServicio();
        return view('pages.tipos_servicios.edit')->with([
            'info' => $info,
            'estados' => $estados
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = TipoServicios::where('nombre', $request->nombre)->where('id', '<>', $request->id)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya existe un tipo de servicio con el nombre que esta ingresando, intente con otro!';
        } else {

            $actualizar = array(
                'nombre' => $request->nombre,
                'estado' => $request->estado
            );

            if(TipoServicios::findOrFail($request->id)->update($actualizar)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar al tipo de servicio!';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(TipoServicios::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el tipo de servicio, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
