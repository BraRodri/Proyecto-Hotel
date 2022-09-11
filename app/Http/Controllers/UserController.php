<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

    public function index()
    {
        return view('pages.usuarios.index');
    }

    public function all()
    {
        $datos = array();

        $data = User::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                $botones .= "<button class='btn btn-primary btn-sm' onclick='verUsuario(".$value->id.");'><i class='fa-solid fa-eye'></i></button>";
                if(Auth::user()->can('Editar Usuarios')){
                    $botones .= "<a href='".route('usuarios.edit', $value->id)."' class='btn btn-success btn-sm'><i class='fa-solid fa-pen'></i></a>";
                }
                if(Auth::user()->can('Eliminar Usuarios')){
                    $botones .= "<button class='btn btn-danger btn-sm' onclick='eliminarUsuario(".$value->id.");'><i class='fa-solid fa-trash'></i></button>";
                }
                $botones .= '</div>';

                $datos[] = array(
                    $value->id,
                    $value->numero_documento,
                    $value->nombres,
                    $value->email,
                    $value->getRoleNames(),
                    "<span class='badge bg-" . Helper::getColorEstadoUser($value->estado) . "'>" . Helper::getEstadoUser($value->estado) . "</span>",
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

        $validar = User::where('email', $request->email)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico ingresado, intente con otro!';
        } else {

            $validar_2 = User::where('numero_documento', $request->numero_documento)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un usuario con el numero documento registrado, intente con otro.';
            } else {

                $registro = array(
                    'tipo_documento' => $request->tipo_documento,
                    'numero_documento' => $request->numero_documento,
                    'nombres' => $request->nombres,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    'profesion' => $request->profesion,
                    'estado' => $request->estado
                );

                if ($request->file('foto')) {
                    $archivo = $request->file('foto')->store('public/usuarios');
                    $registro["foto"] = Storage::url($archivo);
                }

                if ($request->file('archivo_cedula')) {
                    $archivo_2 = $request->file('archivo_cedula')->store('public/usuarios');
                    $registro["archivo_cedula"] = Storage::url($archivo_2);
                }

                if(User::create($registro)->assignRole($request->rol)){
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al registrar al usuario, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function delete($id)
    {
        $error = false;
        $mensaje = '';

        if(User::findOrFail($id)->delete()){
            $error = false;
        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al eliminar al usuario, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $estados = Helper::getDataEstadoUser();
        $tipos_documentos = Helper::getDataTiposDocumentos();
        $roles = Role::all();
        $usuario = User::findOrFail($id);
        return view('pages.usuarios.edit')->with([
            'estados' => $estados,
            'tipos_documentos' => $tipos_documentos,
            'roles' => $roles,
            'usuario' => $usuario,
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = User::where('email', $request->email)->where('id', '<>', $request->id)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error! Ya existe un usuario con el correo electronico ingresado, intente con otro!';
        } else {

            $validar_2 = User::where('numero_documento', $request->numero_documento)->where('id', '<>', $request->id)->get();
            if(count($validar_2) > 0){
                $error = true;
                $mensaje = 'Error! Ya existe un usuario con el numero documento registrado, intente con otro.';
            } else {

                $actualizar = array(
                    'tipo_documento' => $request->tipo_documento,
                    'numero_documento' => $request->numero_documento,
                    'nombres' => $request->nombres,
                    'celular' => $request->celular,
                    'email' => $request->email,
                    'profesion' => $request->profesion,
                    'estado' => $request->estado
                );

                if($request->password){
                    $actualizar["password"] = Hash::make($request->password);
                }

                if ($request->file('foto')) {
                    $archivo = $request->file('foto')->store('public/usuarios');
                    $actualizar["foto"] = Storage::url($archivo);
                }

                if ($request->file('archivo_cedula')) {
                    $archivo_2 = $request->file('archivo_cedula')->store('public/usuarios');
                    $registro["archivo_cedula"] = Storage::url($archivo_2);
                }

                if(User::findOrFail($request->id)->update($actualizar)){
                    //asignar rol nuevo
                    $usuario_nuevo = User::findOrFail($request->id);
                    $usuario_nuevo->syncRoles([$request->rol]);
                    $error = false;
                } else {
                    $error = true;
                    $mensaje = 'Error! Se presento un problema al actualizar al usuario, intenta de nuevo.';
                }

            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function get($id)
    {
        $error = false;
        $mensaje = '';
        $data = array();

        if($usuario = User::findOrFail($id)){

            $imagen = asset('images/user_logo.png');
            if($usuario->foto){
                $imagen = asset($usuario->foto);
            }

            $data = array(
                'tipo_documento' => $usuario->tipo_documento,
                'numero_documento' => $usuario->numero_documento,
                'nombres' => $usuario->nombres,
                'celular' => $usuario->celular,
                'email' => $usuario->email,
                'profesion' => $usuario->profesion,
                'rol' => $usuario->getRoleNames(),
                'estado' => Helper::getEstadoUser($usuario->estado),
                'imagen' => $imagen,
                'archivo' => asset($usuario->archivo_cedula)
            );

        } else {
            $error = true;
            $mensaje = 'Error! Se presento un problema al buscar la información del usuario, intenta de nuevo.';
        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje, 'data' => $data));
    }

}
