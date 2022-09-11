<!-- Modal -->
<div class="modal fade" id="modal_crear_cuarto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Cuarto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_cuarto" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Nombre para cuarto..." required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Tipo de Servicio</label>
                        <select class="form-select" name="tipo" required>
                            <option value="">- Seleccione -</option>
                            @if (count($tipos_servicios) > 0)
                                @foreach ($tipos_servicios as $key => $item)
                                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" min="5000" required>
                    </div>

                    <div class="col-md-12">
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
                        <button type="submit" class="btn btn-danger rounded btn-sm">Registrar Cuarto</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
