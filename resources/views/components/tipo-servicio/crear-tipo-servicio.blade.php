<!-- Modal -->
<div class="modal fade" id="modal_crear_tipo_servicio" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Tipo de Servicio</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_tipo_servicio" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" required>
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
                        <button type="submit" class="btn btn-danger rounded btn-sm">Registrar Información</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
