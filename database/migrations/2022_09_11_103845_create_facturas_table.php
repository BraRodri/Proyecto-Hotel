<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFacturasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facturas', function (Blueprint $table) {
            $table->id();

            $table->bigInteger('servicio_id');
            $table->string('cuarto');
            $table->string('tipo_ingreso');
            $table->string('placa_vehiculo')->nullable();
            $table->string('horas_servicio');
            $table->dateTime('hora_ingreso');
            $table->dateTime('hora_salida');
            $table->float('precio', 15, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('facturas');
    }
}
