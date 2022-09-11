<x-app-layout>

    @section('pagina')Usuarios @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Usuarios</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <h1 class="h3 text-gray-800 flex-grow-1">Usuarios</h1>
            </div>
            <div class="col-lg-6 text-end">
                @can('Crear Usuarios')
                    <button class="btn btn-danger rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modal_crear_usuario">
                        Nuevo Usuario
                    </button>
                @endcan
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Listado de Usuarios
            </div>
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Documento</th>
                            <th>Nombres</th>
                            <th>Correo</th>
                            <th>Rol</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <!-- Importaciones -->
    <x-user.crear-usuario/>
    <x-user.ver-usuario/>

    <x-slot name="js">
        <script>

            var tabla = $('#datatable').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "ajax": route('usuarios.all'),
                "responsive": true
            });

            $('#form_crear_usuario').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_crear_usuario')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('usuarios.create');

                    //agregar data
                    var $thisForm = $('#form_crear_usuario');
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
                                text: "Guardando información, espera un momento por favor...",
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
                                text: "Información Guardada",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#form_crear_usuario')[0].reset();
                            $('#form_crear_usuario').removeClass('was-validated');
                            tabla.ajax.reload();
                            $("#modal_crear_usuario").modal('hide');
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
                $('#form_crear_usuario').addClass('was-validated');
            });

            function eliminarUsuario(id){
                Swal.fire({
                    title: 'Eliminar',
                    text: "¿Estás seguro de eliminar al usuario?",
                    icon: 'warning',
                    showCancelButton: true,
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Si, eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            type: "GET",
                            encoding:"UTF-8",
                            url: route('usuarios.delete', id),
                            dataType:'json',
                            beforeSend:function(){
                                Swal.fire({
                                    title: "Espera!",
                                    text: "Eliminando al usuario...",
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
                                    text: "Usuario Eliminado",
                                    icon: 'success',
                                    showConfirmButton: false,
                                    timer: 3000
                                });

                                tabla.ajax.reload();
                            } else {
                                Swal.fire({
                                    title: "Se presento un error!",
                                    html: respuesta.mensaje,
                                    icon: 'error',
                                });
                            }
                        }).fail(function(resp){
                            console.log(resp);
                        });
                    }
                });
            }

            function verUsuario(id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "GET",
                    encoding:"UTF-8",
                    url: route('usuarios.get', id),
                    dataType:'json',
                    beforeSend:function(){
                        Swal.fire({
                            title: "Espera!",
                            text: "Cargando información...",
                            timerProgressBar: true,
                            didOpen: () => {
                                Swal.showLoading();
                            },
                        });
                    }
                }).done(function(respuesta){
                    console.log(respuesta);
                    if (!respuesta.error) {

                        var info = respuesta.data;

                        //imprimiendo la info
                        $('#lb_nombre_usuario').text(info.nombres);
                        $('#lb_tipo_documento').val(info.tipo_documento);
                        $('#lb_numero_documento').val(info.numero_documento);
                        $('#lb_nombres').val(info.nombres);
                        $('#lb_apellidos').val(info.apellidos);
                        $('#lb_celular').val(info.celular);
                        $('#lb_email').val(info.email);
                        $('#lb_profesion').val(info.profesion);
                        $('#lb_rol').val(info.rol);
                        $('#lb_estado').val(info.estado);
                        $("#imagen_perfil").attr("src", info.imagen);
                        $("#url_archivo").attr("href", info.archivo);

                        Swal.fire({
                            text: "Información Cargada",
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_ver_usuario').modal('show');
                    } else {
                        $('#modal_ver_usuario').modal('hide');
                        Swal.fire({
                            title: "Se presento un error!",
                            html: respuesta.mensaje,
                            icon: 'error',
                        });
                    }
                }).fail(function(resp){
                    $('#modal_ver_usuario').modal('hide');
                    console.log(resp);
                });
            }

        </script>
    </x-slot>

</x-app-layout>
