<!-- Modal -->
<div class="modal fade" id="modal_crear_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Nuevo Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <form id="form_crear_usuario" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo de Documento</label>
                        <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                            <option value="">- Seleccione -</option>
                            @if (count($tipos_documentos) > 0)
                                @foreach ($tipos_documentos as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Numero de Documento</label>
                        <input type="text" class="form-control" id="numero_documento" name="numero_documento" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="nombres" name="nombres" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="celular" name="celular" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Correo Electronico</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Profesión</label>
                        <input type="text" class="form-control" id="profesion" name="profesion" required>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Rol</label>
                        <select class="form-select" name="rol" id="rol" required>
                            <option value="">- Seleccione -</option>
                            @if (count($roles) > 0)
                                @foreach ($roles as $item)
                                    <option value="{{ $item->name }}">{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-4">
                        <label for="" class="form-label">Estado</label>
                        <select class="form-select" name="estado" id="estado" required>
                            <option value="">- Seleccione -</option>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $item)
                                    <option value="{{ $key }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Foto de Perfil</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Documento del Documento de Identidad</label>
                        <input class="form-control" type="file" id="archivo_cedula" name="archivo_cedula">
                    </div>

                    <div class="col-12 pt-3" style="text-align: right">
                        <button type="submit" class="btn btn-danger rounded btn-sm">Crear Usuario</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
