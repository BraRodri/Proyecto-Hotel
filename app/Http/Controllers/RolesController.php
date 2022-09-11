<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesController extends Controller
{

    public function index()
    {
        return view('pages.roles_permisos.index');
    }

    public function all()
    {
        $datos = array();

        $data = Role::all();
        if(count($data) > 0){
            foreach ($data as $key => $value) {

                $botones = '';
                $botones .= '<div class="btn-group" role="group">';
                if(Auth::user()->can('Editar Roles')){
                    $botones .= "<a href='".route('roles.edit', $value->id)."' class='btn btn-success btn-sm'><i class='fa-solid fa-pen'></i> Editar</a>";
                }
                $botones .= '</div>';

                $permisos = '';
                $permisos_arr = $value->permissions;
                if(count($permisos_arr) > 0){
                    foreach ($permisos_arr as $key => $value_p) {
                        $permisos .= '<span class="badge bg-success mr-2">'.$value_p->name.'</span>';
                    }
                }

                $datos[] = array(
                    $value->id,
                    $value->name,
                    $permisos,
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

        $validar = Role::where('name', $request->nombre)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya se encuentra un rol registrado con ese mismo nombre, intente con otro!';
        } else {

            if($rol_creado = Role::create(['name' => $request->nombre])){

                $permisos = $request->permisos;
                if(is_array($permisos)){
                    if (count($permisos) > 0) {
                        foreach ($permisos as $key => $value_p) {
                            $rol_creado->givePermissionTo($value_p);
                        }
                    }
                }

                $error = false;

            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al crear el rol.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

    public function edit($id)
    {
        $rol = Role::findOrFail($id);
        $permisos = Permission::all();
        $permisos_rol = $rol->permissions;
        return view('pages.roles_permisos.edit')->with([
            'rol' => $rol,
            'permisos' => $permisos,
            'permisos_rol' => $permisos_rol
        ]);
    }

    public function update(Request $request)
    {
        $error = false;
        $mensaje = '';

        $validar = Role::where('name', $request->nombre)->where('id', '<>', $request->id)->exists();
        if($validar){
            $error = true;
            $mensaje = 'Error, ya se encuentra un rol registrado con ese mismo nombre, intente con otro!';
        } else {

            $rol_encontrado = Role::findOrFail($request->id);
            $permisos_rol = $rol_encontrado->permissions;
            if(count($permisos_rol) > 0){
                foreach ($permisos_rol as $key => $value) {
                    $rol_encontrado->revokePermissionTo($value->name);
                }
            }

            if($rol_creado = Role::findOrFail($request->id)->update(['name' => $request->nombre])){

                $rol_actualizado = Role::findOrFail($request->id);
                $permisos = $request->permisos;
                if(is_array($permisos)){
                    if (count($permisos) > 0) {
                        foreach ($permisos as $key => $value_p) {
                            $rol_actualizado->givePermissionTo($value_p);
                        }
                    }
                }

                $error = false;

            } else {
                $error = true;
                $mensaje = 'Error, se presento un problema al actualizar el rol.';
            }

        }

        echo json_encode(array('error' => $error, 'mensaje' => $mensaje));
    }

}
