<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\Cuartos;
use App\Models\Facturas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Rap2hpoutre\FastExcel\FastExcel;

class FacturaController extends Controller
{

    public function index()
    {
        return view('pages.facturas.index');
    }

    public function all()
    {
        $datos = array();

        $data = Facturas::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                if(Auth::user()->can('Eliminar Facturas')){
                    $botones .= "<button onclick='eliminar(".$value->id.");' class='btn btn-danger btn-sm'><i class='fa-solid fa-trash'></i></button>";
                }
                if(Auth::user()->can('Descargar Facturas')){
                    $botones .= "<a href='".route('facturas.imprimir', $value->id)."' target='_blank' class='btn btn-dark btn-sm'><i class='fa-solid fa-file-invoice'></i></button>";
                }
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->cuarto,
                    $value->tipo_ingreso,
                    $value->horas_servicio,
                    $value->hora_ingreso,
                    $value->hora_salida,
                    '$'.number_format($value->precio, 0, ",", "."),
                    $botones
                );

            }
        }

        echo json_encode([
            'data' => $datos,
        ]);
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(Facturas::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar la factura, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function imprimir($id)
    {
        //datos
        $factura = Facturas::findOrFail($id);
        $num_factura = substr(str_repeat(0, 5).$factura->id, - 5);

        $pdf = Pdf::loadView('pdf.factura', compact('factura'));
        return $pdf->stream("factura_$num_factura.pdf");
        //return $pdf->download("factura_$num_factura.pdf");
    }

    public function reportes()
    {
        $cuartos = Cuartos::all();
        $tipos_ingreso = Helper::getDataTiposIngresos();
        $estados = Helper::getDataEstadoServicios();
        return view('pages.facturas.reportes')->with([
            'cuartos' => $cuartos,
            'tipos_ingreso' => $tipos_ingreso,
            'estados' => $estados
        ]);
    }

    public function generarReportes(Request $request)
    {
        $fecha_i = $request->fecha_desde;
        $fecha_n = $request->fecha_hasta;

        $datos = Facturas::where('id', '<>', '');

        if($request->cuartos != null){
            $datos = $datos->where('cuarto', $request->cuartos);
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

        //dd('hola');
        return (new FastExcel($datos))->download('reporte_facturas_'.date('YmdHms').'.xlsx', function ($data) {
            return [
                "#" => $data->id,
                "Cuarto" => $data->cuarto,
                "Tipo de Ingreso" => $data->tipo_ingreso,
                "Placa del Vehiculo" => $data->placa_vehiculo,
                "Horas del Servicio" => $data->horas_servicio,
                "Fecha de Ingreso" => $data->hora_ingreso,
                "Fecha de Salida" => $data->hora_salida,
                "Precio" => $data->precio,
                "Fecha Creación" => date("Y-m-d h:i:s a", strtotime($data->created_at))
            ];
        });
    }

}
