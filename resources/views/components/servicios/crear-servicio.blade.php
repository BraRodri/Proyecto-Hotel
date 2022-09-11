<!-- Modal -->
<div class="modal fade" id="modal_crear_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_servicio" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="form-label">Primero, seleccione un cuarto disponible</label>
                        <select class="form-select" name="cuarto" id="select_cuarto" required>
                            <option value="">- Seleccione -</option>
                            @if (count($cuartos) > 0)
                                @foreach ($cuartos as $key => $item)
                                    <option value="{{ $item->id }}" id="cuarto_id_{{ $item->id }}" precio="{{ $item->precio }}">{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Tipo de Ingreso</label>
                        <select class="form-select" name="tipo_ingreso" id="select_tipo_ingreso" required>
                            <option value="">- Seleccione -</option>
                            @if (count($tipos_ingresos) > 0)
                                @foreach ($tipos_ingresos as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Placa del Vehiculo</label>
                        <input type="text" class="form-control text-uppercase" id="input_placa" name="placa">
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Horas del Servicio</label>
                        <select class="form-select" name="horas_servicio" id="horas_servicio" required>
                            <option value="">- Seleccione -</option>
                            @if (count($horas_servicio) > 0)
                                @foreach ($horas_servicio as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Hora de Ingreso</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso" required>
                            </div>
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="hora_ingreso" name="hora_ingreso" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Hora de Salida</label>
                        <div class="row">
                            <div class="col-md-6">
                                <input type="date" class="form-control" id="fecha_salida" name="fecha_salida" required>
                            </div>
                            <div class="col-md-6">
                                <input type="time" class="form-control" id="hora_salida" name="hora_salida" required>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="input_precio" name="precio" min="5000" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Estado</label>
                        <select class="form-select" name="estado" required>
                            <option value="">- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-danger rounded btn-sm">Registrar Servicio</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
