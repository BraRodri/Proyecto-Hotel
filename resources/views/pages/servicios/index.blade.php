<x-app-layout>

    @section('pagina')Gestión de Servicios @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Gestión de Servicios</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-6">
                <h1 class="h3 text-gray-800 flex-grow-1">Gestión de Servicios</h1>
            </div>
            @can('Crear Servicios')
                <div class="col-lg-6 text-end">
                    <button class="btn btn-danger rounded btn-sm" data-bs-toggle="modal" data-bs-target="#modal_crear_servicio">
                        Nuevo Servicio
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
                            <th>Cuarto</th>
                            <th>Tipo Ingreso</th>
                            <th>Hrs Servicio</th>
                            <th>Hora Ingreso</th>
                            <th>Hora Salida</th>
                            <th>Precio</th>
                            <th>Estado</th>
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
                            <th>Estado</th>
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
                "ajax": route('servicios.all'),
                "responsive": true
            });

            $('#form_crear_servicio').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_crear_servicio')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('servicios.create');

                    //agregar data
                    var $thisForm = $('#form_crear_servicio');
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
                            $('#form_crear_servicio')[0].reset();
                            $('#form_crear_servicio').removeClass('was-validated');
                            tabla.ajax.reload();
                            $("#modal_crear_servicio").modal('hide');
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
                $('#form_crear_servicio').addClass('was-validated');
            });

            $('#select_cuarto').on('change', function(){
                var dato = this.value;
                if(dato != ''){
                    var precio_cuarto = $('#cuarto_id_'+dato).attr('precio');
                    $('#input_precio').val(precio_cuarto);
                } else {
                    $('#input_precio').val('');
                }
            });

            $('#select_tipo_ingreso').on('change', function(){
                var dato = this.value;
                if(dato != ''){
                    if(dato == '3'){
                        $('#input_placa').attr("required", false);
                    } else {
                        $('#input_placa').attr("required", true);
                    }
                } else {
                    $('#input_placa').attr("required", false);
                }
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
                            url: route('servicios.delete', id),
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

            function ver(id){
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    type: "GET",
                    encoding:"UTF-8",
                    url: route('servicios.get', id),
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
                        $('#lb_tipo_servicio').val(info.cuarto_tipo_servicio);
                        $('#lb_cuarto').val(info.cuarto);

                        $('#lb_tipo_ingreso').val(info.tipo_ingreso);
                        $('#lb_placa').val(info.placa);
                        $('#lb_horas_servicio').val(info.horas_servicio);

                        $('#lb_hora_ingreso').val(info.hora_ingreso);
                        $('#lb_hora_salida').val(info.hora_salida);
                        $('#lb_precio').val(info.precio);
                        $('#lb_estado').val(info.estado);

                        Swal.fire({
                            text: "Información Cargada",
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 2000
                        });
                        $('#modal_ver_servicio').modal('show');
                    } else {
                        $('#modal_ver_servicio').modal('hide');
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

            function editar(id){
                (async () => {

                    const { value: estado } = await Swal.fire({
                        title: 'Actualizar Estado',
                        input: 'select',
                        inputOptions: {
                            '1': 'Iniciado',
                            '2': 'Finalizado'
                        },
                        showCancelButton: true,
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Actualizar',
                        inputValidator: (result) => {
                            return !result && 'Debes seleccionar un estado!'
                        }
                    });

                    if (estado) {

                        var formData = new FormData();
                        formData.append('id', id);
                        formData.append('estado', estado);

                        $.ajax({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf_token"]').attr('content')
                            },
                            type: "POST",
                            encoding:"UTF-8",
                            url: route('servicios.update'),
                            data: formData,
                            processData: false,
                            contentType: false,
                            dataType:'json',
                            beforeSend:function(){
                                //mensaje de alerta
                                let timerInterval;
                                Swal.fire({
                                    title: "Cargando",
                                    text: "Actualizando la información, espere...",
                                    timerProgressBar: true,
                                    didOpen: () => {
                                        Swal.showLoading();
                                    },
                                });
                            }
                        }).done(function(respuesta){
                            console.log(respuesta);
                            if (!respuesta.error) {
                                location.reload();
                            } else {
                                setTimeout(function(){
                                    Swal.fire({
                                        title: "Se presento un error!",
                                        text: respuesta.mensaje,
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

                })();
            };

        </script>
    </x-slot>

</x-app-layout>
