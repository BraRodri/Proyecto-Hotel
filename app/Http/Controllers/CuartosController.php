<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Cuartos;
use App\Models\TipoServicios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CuartosController extends Controller
{

    public function index()
    {
        return view('pages.cuartos.index');
    }

    public function all()
    {
        $datos = array();

        $data = Cuartos::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                if(Auth::user()->can('Editar Cuartos')){
                    $botones .= "<a href='".route('cuartos.edit', $value->id)."' class='btn btn-success btn-sm'><i class='fa-solid fa-pen'></i> Editar</a>";
                }
                if(Auth::user()->can('Eliminar Cuartos')){
                    $botones .= "<button onclick='eliminar(".$value->id.");' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i> Eliminar</button>";
                }
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->nombre,
                    ($value->tipoServicios) ? $value->tipoServicios->nombre : '',
                    '$'.number_format($value->precio, 0, ",", "."),
                    "<span class='badge bg-" . Helper::getColorEstadosCuartos($value->estado) . "'>" . Helper::getEstadosCuartos($value->estado) . "</span>",
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

        $validar = Cuartos::where('nombre', $request->nombre)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya existe un cuarto registrado con el nombre que esta ingresando, intente con otro!';
        } else {

            $crear = array(
                'nombre' => $request->nombre,
                'tipo_servicio_id' => $request->tipo,
                'precio' => $request->precio,
                'estado' => $request->estado
            );

            if(Cuartos::create($crear)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al crear el cuarto!';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $tipos_servicios = TipoServicios::where('estado', 1)->get();
        $estados = Helper::getDataEstadosCuartos();
        $info = Cuartos::findOrFail($id);
        return view('pages.cuartos.edit')->with([
            'tipos_servicios' => $tipos_servicios,
            'estados' => $estados,
            'info' => $info
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = Cuartos::where('nombre', $request->nombre)->where('id', '<>', $request->id)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya existe un cuarto registrado con el nombre que esta ingresando, intente con otro!';
        } else {

            $actualizar = array(
                'nombre' => $request->nombre,
                'tipo_servicio_id' => $request->tipo,
                'precio' => $request->precio,
                'estado' => $request->estado
            );

            if(Cuartos::findOrFail($request->id)->update($actualizar)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar la información del cuarto!';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(Cuartos::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el cuarto, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
