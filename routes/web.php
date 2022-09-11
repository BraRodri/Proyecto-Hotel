<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CuartosController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\ServiciosController;
use App\Http\Controllers\TipoServiciosController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('storage-link',function(){
    Artisan::call('storage:link');
});

Auth::routes();

#Auth
Route::post('/validar-login', [LoginController::class, 'login'])->name('validar_login');

#Para el administrador
Route::group(['middleware' => 'auth', 'prefix' => '/panel'], function () {

    #Principal
    Route::controller(HomeController::class)
        ->group(function () {

        #Inicio
        Route::get('/', 'index')->name('panel');

    });

    #Usuarios
    Route::controller(UserController::class)
        ->group(function () {

            Route::get('/usuarios', 'index')->name('usuarios.index');
            Route::get('/usuarios/all', 'all')->name('usuarios.all');
            Route::post('/usuarios/create', 'create')->name('usuarios.create');
            Route::get('/usuarios/delete/{id}', 'delete')->name('usuarios.delete');
            Route::get('/usuarios/edit/{id}', 'edit')->name('usuarios.edit');
            Route::post('/usuarios/update', 'update')->name('usuarios.update');
            Route::get('/usuarios/get/{id}', 'get')->name('usuarios.get');

    });

    #Roles y Permisos
    Route::controller(RolesController::class)
        ->prefix('configuracion/roles')->group(function () {

            Route::get('/', 'index')->name('roles.index');
            Route::post('/create', 'create')->name('roles.create');
            Route::get('/all', 'all')->name('roles.all');
            Route::get('edit/{id}', 'edit')->name('roles.edit');
            Route::post('/update', 'update')->name('roles.update');

    });

    #Tipos servicios
    Route::controller(TipoServiciosController::class)
        ->prefix('configuracion/tipos-servicios')->group(function () {

            Route::get('/', 'index')->name('tipos_servicios.index');
            Route::post('/create', 'create')->name('tipos_servicios.create');
            Route::get('/all', 'all')->name('tipos_servicios.all');
            Route::get('edit/{id}', 'edit')->name('tipos_servicios.edit');
            Route::post('/update', 'update')->name('tipos_servicios.update');
            Route::get('delete/{id}', 'delete')->name('tipos_servicios.delete');

    });

    #Gestión de Cuartos
    Route::controller(CuartosController::class)
        ->prefix('gestion-cuartos')->group(function () {

            Route::get('/', 'index')->name('cuartos.index');
            Route::post('/create', 'create')->name('cuartos.create');
            Route::get('/all', 'all')->name('cuartos.all');
            Route::get('edit/{id}', 'edit')->name('cuartos.edit');
            Route::post('/update', 'update')->name('cuartos.update');
            Route::get('delete/{id}', 'delete')->name('cuartos.delete');

    });

    #Gestión de Servicios
    Route::controller(ServiciosController::class)
        ->prefix('servicios')->group(function () {

            Route::get('/', 'index')->name('servicios.index');
            Route::post('/create', 'create')->name('servicios.create');
            Route::get('/all', 'all')->name('servicios.all');
            Route::get('edit/{id}', 'edit')->name('servicios.edit');
            Route::post('/update', 'update')->name('servicios.update');
            Route::get('delete/{id}', 'delete')->name('servicios.delete');
            Route::get('/get/{id}', 'get')->name('servicios.get');
            Route::get('/factura/{id}', 'factura')->name('servicios.factura');

            Route::get('/reportes', 'reportes')->name('servicios.reportes');
            Route::post('/reportes/generar', 'generarReportes')->name('servicios.reportes.generar');

    });

    #Facturas
    Route::controller(FacturaController::class)
        ->prefix('facturas')->group(function () {

            Route::get('/', 'index')->name('facturas.index');
            Route::get('/all', 'all')->name('facturas.all');
            Route::get('imprimir/{id}', 'imprimir')->name('facturas.imprimir');
            Route::get('delete/{id}', 'delete')->name('facturas.delete');

            Route::get('/reportes', 'reportes')->name('facturas.reportes');
            Route::post('/reportes/generar', 'generarReportes')->name('facturas.reportes.generar');

    });

});

