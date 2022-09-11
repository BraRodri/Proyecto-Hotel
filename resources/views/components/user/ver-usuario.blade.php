<!-- Modal -->
<div class="modal fade" id="modal_ver_usuario" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Información del Usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">

                <div class="row g-3">
                    @csrf

                    <div class="col-md-12 text-center">
                        <img src="{{ asset('images/user_logo.png') }}" id="imagen_perfil" class="img-fluid img-thumbnail rounded-circle img-usuario">
                        <h4 id="lb_nombre_usuario" class="mt-4 mb-3"><strong>Nombre del usuario</strong></h4>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Tipo de Documento</label>
                        <input type="text" class="form-control" id="lb_tipo_documento" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Numero de Documento</label>
                        <input type="text" class="form-control" id="lb_numero_documento" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Nombres</label>
                        <input type="text" class="form-control" id="lb_nombres" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Celular</label>
                        <input type="text" class="form-control" id="lb_celular" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Correo Electronico</label>
                        <input type="text" class="form-control" id="lb_email" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Profesión</label>
                        <input type="text" class="form-control" id="lb_profesion" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Rol</label>
                        <input type="text" class="form-control" id="lb_rol" disabled>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Estado</label>
                        <input type="text" class="form-control" id="lb_estado" disabled>
                    </div>

                    <div class="col-md-12 mt-4">
                        <label for="" class="form-label">Archivo del Documento de Identidad</label><br>
                        <a href="#" target="_blank" id="url_archivo">Ver Documento</a>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
