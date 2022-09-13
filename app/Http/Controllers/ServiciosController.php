<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Cuartos;
use App\Models\Facturas;
use App\Models\Servicios;
use Barryvdh\DomPDF\Facade\Pdf;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class ServiciosController extends Controller
{

    public function index()
    {
        return view('pages.servicios.index');
    }

    public function all()
    {
        $datos = array();

        $data = Servicios::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<button class='btn btn-primary btn-sm' onclick='ver(".$value->id.");'><i class='fa-solid fa-eye'></i></button>";
                if($value->estado == 1){
                    if(Auth::user()->can('Editar Servicios')){
                        $botones .= "<button onclick='editar(".$value->id.");' class='btn btn-success btn-sm'><i class='fa-solid fa-pen'></i></button>";
                    }
                    if(Auth::user()->can('Eliminar Servicios')){
                        $botones .= "<button onclick='eliminar(".$value->id.");' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></button>";
                    }
                } else {
                    if(Auth::user()->can('Eliminar Servicios')){
                        $botones .= "<button onclick='eliminar(".$value->id.");' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></button>";
                    }
                    //$botones .= "<a href='".route('servicios.factura', $value->id)."' target='_blank' class='btn btn-dark btn-sm'><i class='fa-solid fa-file-invoice'></i></a>";
                }
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    ($value->cuarto) ? $value->cuarto->nombre : '',
                    Helper::getTiposIngresos($value->tipo_ingreso),
                    $value->horas_servicio,
                    $value->hora_ingreso,
                    $value->hora_salida,
                    $value->tipo_pago,
                    '$'.number_format($value->precio, 0, ",", "."),
                    "<span class='badge bg-" . Helper::getColorEstadoServicio($value->estado) . "'>" . Helper::getEstadoServicio($value->estado) . "</span>",
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

        $fecha_ingreso = $request->fecha_ingreso . " " . $request->hora_ingreso;
        $fecha_salida = $request->fecha_salida . " " . $request->hora_salida;

        $crear = array(
            'cuarto_id' => $request->cuarto,
            'tipo_ingreso' => $request->tipo_ingreso,
            'placa_vehiculo' => $request->placa,
            'horas_servicio' => $request->horas_servicio,
            'hora_ingreso' => $fecha_ingreso,
            'hora_salida' => $fecha_salida,
            'tipo_pago' => $request->pago,
            'precio' => $request->precio,
            'estado' => $request->estado,
        );

        if($resultado = Servicios::create($crear)){

            //actualizar el estado del cuarto
            $act_cuarto = array(
                'estado' => 2
            );
            if(Cuartos::findOrFail($request->cuarto)->update($act_cuarto)){

                //crear factura
                $cuarto = Cuartos::find($request->cuarto);
                $crear_factura = array(
                    'servicio_id' => $resultado->id,
                    'cuarto' => $cuarto->nombre,
                    'tipo_ingreso' => Helper::getTiposIngresos($request->tipo_ingreso),
                    'placa_vehiculo' => $request->placa,
                    'horas_servicio' => $request->horas_servicio,
                    'hora_ingreso' => $fecha_ingreso,
                    'hora_salida' => $fecha_salida,
                    'tipo_pago' => $request->pago,
                    'precio' => $request->precio,
                );
                if(Facturas::create($crear_factura)){
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error, se presento un problema al crear la factura';
                }

            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar el estado del cuarto';
            }

        } else {
            $error = true;
            $mensaje = 'Error, se presento un problema al crear el servicio, intenta de nuevo!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(Servicios::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar el servicio, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function get($id)
    {
        $error = false;
        $mensaje = '';
        $data = array();

        if($data = Servicios::findOrFail($id)){

            $data = array(
                'cuarto' => ($data->cuarto) ? $data->cuarto->nombre : '',
                'cuarto_tipo_servicio' => ($data->cuarto->tipoServicios) ? $data->cuarto->tipoServicios->nombre : '',
                'tipo_ingreso' => Helper::getTiposIngresos($data->tipo_ingreso),
                'placa' => $data->placa_vehiculo,
                'horas_servicio' => $data->horas_servicio,
                'hora_ingreso' => $data->hora_ingreso,
                'hora_salida' => $data->hora_salida,
                'precio' => '$'.number_format($data->precio, 0, ",", "."),
                'estado' => Helper::getEstadoServicio($data->estado),
                'tipo_pago' => $data->tipo_pago
            );

        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al buscar la información del servicio, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'data' => $data));
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $servicio = Servicios::findOrFail($request->id);
        $actualizar = array(
            'estado' => $request->estado
        );

        if(Servicios::findOrFail($request->id)->update($actualizar)){

            //actualizar el estado del cuarto
            if($request->estado == 1) {
                $act_cuarto = array(
                    'estado' => 2
                );
            } else {
                $act_cuarto = array(
                    'estado' => 1
                );
            }

            if(Cuartos::findOrFail($servicio->cuarto_id)->update($act_cuarto)){
                $error = false;
            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar el estado del cuarto';
            }

        } else {
            $error = true;
            $mensaje = 'Error, se presento un problema al actualizar el servicio, intenta de nuevo!';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function reportes()
    {
        $cuartos = Cuartos::all();
        $tipos_ingreso = Helper::getDataTiposIngresos();
        $estados = Helper::getDataEstadoServicios();
        return view('pages.servicios.reportes')->with([
            'cuartos' => $cuartos,
            'tipos_ingreso' => $tipos_ingreso,
            'estados' => $estados
        ]);
    }

    public function generarReportes(Request $request)
    {
        $fecha_i = $request->fecha_desde;
        $fecha_n = $request->fecha_hasta;

        $datos = Servicios::where('id', '<>', '');

        if($request->cuartos != null){
            $datos = $datos->where('cuarto_id', $request->cuartos);
        }

        if($request->tipo_ingreso != null){
            $datos = $datos->where('tipo_ingreso', $request->tipo_ingreso);
        }

        if($request->estado != null){
            $datos = $datos->where('estado', $request->estado);
        }

        if($request->fecha_desde != null && $request->fecha_hasta != null){
            $datos = $datos->whereBetween(DB::raw('DATE(created_at)'), [$fecha_i, $fecha_n]);
        }

        $datos = $datos->get();

        if($request->tipo == 1){

            $pdf = Pdf::loadView('pdf.reporte', compact('datos'));
            return $pdf->stream("pdf_reporte_servicios.pdf");

        } else {

            //dd('hola');
            return (new FastExcel($datos))->download('reporte_servicios_'.date('YmdHms').'.xlsx', function ($data) {
                return [
                    "#" => $data->id,
                    "Tipo Servicio Cuarto" => ($data->cuarto) ? $data->cuarto->tipoServicios->nombre : '',
                    "Cuarto" => ($data->cuarto) ? $data->cuarto->nombre : '',
                    "Tipo de Ingreso" => Helper::getTiposIngresos($data->tipo_ingreso),
                    "Placa del Vehiculo" => $data->placa_vehiculo,
                    "Horas del Servicio" => $data->horas_servicio,
                    "Fecha de Ingreso" => $data->hora_ingreso,
                    "Fecha de Salida" => $data->hora_salida,
                    "Tipo de Pago" => $data->tipo_pago,
                    "Precio" => $data->precio,
                    "Estado" => Helper::getEstadoServicio($data->estado),
                    "Fecha Creación" => date("Y-m-d h:i:s a", strtotime($data->created_at))
                ];
            });

        }

    }

}
