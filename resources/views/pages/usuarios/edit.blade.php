<x-app-layout>

    @section('pagina')Actualizar Usuario @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('usuarios.index') }}">Usuarios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Usuario</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Usuario</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Actualizar
            </div>
            <div class="card-body">
                <form id="form_editar_usuario" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-3 col-12 align-self-center">
                        <div class="text-center">
                            <p>FOTO DE PERFIL</p>
                            @if ($usuario->foto)
                                <img src="{{ asset($usuario->foto) }}" class="img-fluid img-thumbnail">

                                @else
                                <img src="{{ asset('images/user_logo.png') }}" class="img-fluid img-thumbnail">
                            @endif
                        </div>
                    </div>

                    <div class="col-md-9 col-12 row g-3">
                        <div class="col-md-6">
                            <label for="" class="form-label">Tipo de Documento</label>
                            <select class="form-select" name="tipo_documento" id="tipo_documento" required>
                                <option value="">- Seleccione -</option>
                                @if (count($tipos_documentos) > 0)
                                    @foreach ($tipos_documentos as $key => $item)
                                        @php
                                            $selected = ($usuario->tipo_documento == $item) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $item }}" {{ $selected }}>{{ $item }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Numero de Documento</label>
                            <input type="text" class="form-control" id="numero_documento" name="numero_documento" value="{{ $usuario->numero_documento }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" value="{{ $usuario->nombres }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" value="{{ $usuario->celular }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Correo Electronico</label>
                            <input type="email" class="form-control" id="email" name="email" value="{{ $usuario->email }}" required>
                        </div>

                        <div class="col-md-6">
                            <label for="" class="form-label">Contraseña</label>
                            <input type="password" class="form-control" id="password" name="password">
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Profesión</label>
                            <input type="text" class="form-control" id="profesion" name="profesion" value="{{ $usuario->profesion }}" required>
                        </div>

                        <div class="col-md-4">
                            <label for="" class="form-label">Rol</label>
                            <select class="form-select" name="rol" id="rol" required>
                                <option value="">- Seleccione -</option>
                                @if (count($roles) > 0)
                                    @foreach ($roles as $item)
                                        @php
                                            $selected = ($usuario->getRoleNames()[0] == $item->name) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $item->name }}" {{ $selected }}>{{ $item->name }}</option>
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
                                        @php
                                            $selected = ($usuario->estado == $key) ? 'selected' : '';
                                        @endphp
                                        <option value="{{ $key }}" {{ $selected }}>{{ $item }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Foto de Perfil</label>
                        <input class="form-control" type="file" id="foto" name="foto">
                    </div>

                    <div class="col-md-6">
                        <label for="" class="form-label">Documento del Documento de Identidad</label>
                        <input class="form-control" type="file" id="archivo_cedula" name="archivo_cedula"><br>
                        <a href="{{ asset($usuario->archivo_cedula) }}" target="_blank">Ver Documento adjuntado</a>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $usuario->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('usuarios.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                        <button type="submit" class="btn btn-danger rounded btn-sm">Actualizar Usuario</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#form_editar_usuario').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar_usuario')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('usuarios.update');

                    //agregar data
                    var $thisForm = $('#form_editar_usuario');
                    var formData = new FormData(this);

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        type: "POST",
                        encoding:"UTF-8",
                        url: url,
                        data: formData,
                        processData: false,
                        contentType: false,
                        dataType:'json',
                        beforeSend:function(){
                            let timerInterval;
                            Swal.fire({
                                title: "Espera!",
                                text: "Actualizando la información...",
                                timerProgressBar: true,
                                didOpen: () => {
                                    Swal.showLoading();
                                },
                            });
                        }
                    }).done(function(respuesta){
                        //console.log(respuesta);
                        if (!respuesta.error) {
                            Swal.fire({
                                text: "Información Actualizada",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });

                            location.href = route('usuarios.index');

                        } else {
                            setTimeout(function(){
                                Swal.fire({
                                    title: "Se presento un error!",
                                    html: respuesta.mensaje,
                                    icon: 'error',
                                });
                            },2000);
                        }
                    }).fail(function(resp){
                        console.log(resp);
                        Swal.fire({
                            title: "Se presento un error!",
                            text: 'Intenta otra vez, si persiste el error, comunicate con el area encargada, gracias.',
                            icon: 'error',
                        });
                    });

                }
                $('#form_editar_usuario').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
