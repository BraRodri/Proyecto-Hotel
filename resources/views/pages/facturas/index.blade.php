<x-app-layout>

    @section('pagina')Facturas @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Facturas</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Facturas</h1>
            </div>
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
                            <th>Cuarto</th>
                            <th>Tipo Ingreso</th>
                            <th>Hrs Servicio</th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>#</th>
                            <th>Cuarto</th>
                            <th>Tipo Ingreso</th>
                            <th>Hrs Servicio</th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Precio</th>
                            <th>Acciones</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

    </div>

    <!-- Importaciones -->
    <x-servicios.crear-servicio/>
    <x-servicios.ver-servicio/>

    <x-slot name="js">
        <script>

            var tabla = $('#datatable').DataTable({
                "processing": true,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.11.4/i18n/es_es.json"
                },
                "order": [[ 0, "desc" ]],
                "pageLength" : 25,
                "ajax": route('facturas.all'),
                "responsive": true
            });

            function eliminar(id){
                Swal.fire({
                    title: 'Eliminar',
                    text: "¿Estás seguro de eliminar el servicio?",
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
                            url: route('facturas.delete', id),
                            dataType:'json',
                            beforeSend:function(){
                                Swal.fire({
                                    title: "Espera!",
                                    text: "Eliminando el registro...",
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
                                    text: "Registro Eliminado",
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

        </script>
    </x-slot>

</x-app-layout>
