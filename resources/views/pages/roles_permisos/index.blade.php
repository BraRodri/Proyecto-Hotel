<x-app-layout>

    @section('pagina')Roles y Permisos @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Configuración</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Roles y Permisos</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <h1 class="h3 text-gray-800 flex-grow-1">Roles y Permisos</h1>
            </div>
            @can('Crear Roles')
                <div class="col-lg-6 text-end">
                    <button class="btn btn-danger rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modal_crear_rol">
                        Nuevo Rol
                    </button>
                </div>
            @endcan
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Listado
            </div>
            <div class="card-body">
                <table class="table" id="datatable" style="width: 100%;">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Nombre</th>
                            <th>Permisos</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <!-- Importaciones -->
    <x-roles-permisos.crear-rol/>

    <x-slot name="js">
        <script>

            var tabla = $('#datatable').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "ajax": route('roles.all'),
                "responsive": true
            });

            $('#form_crear_rol').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_crear_rol')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('roles.create');

                    //agregar data
                    var $thisForm = $('#form_crear_rol');
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
                        console.log(respuesta);
                        if (!respuesta.error) {
                            Swal.fire({
                                text: "Información Guardada",
                                icon: 'success',
                                showConfirmButton: false,
                                timer: 3000
                            });
                            $('#form_crear_rol')[0].reset();
                            $('#form_crear_rol').removeClass('was-validated');
                            tabla.ajax.reload();
                            $("#modal_crear_rol").modal('hide');
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
                $('#form_crear_rol').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
