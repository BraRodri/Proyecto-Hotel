<x-app-layout>

    @section('pagina')Actualizar Cuarto @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('cuartos.index') }}">Gestión de Cuartos</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Cuarto</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Cuarto</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Actualizar
            </div>
            <div class="card-body">
                <form id="form_editar_informacion" class="row g-3 needs-validation" method="POST" novalidate enctype="multipart/form-data">
                    @csrf

                    <div class="col-md-12">
                        <label for="" class="form-label">Nombre</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $info->nombre }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Tipo de Servicio</label>
                        <select class="form-select" name="tipo" required>
                            @if (count($tipos_servicios) > 0)
                                @foreach ($tipos_servicios as $key => $item)
                                    @php
                                        $selected = ($info->tipo_servicio_id == $item->id) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $item->id }}" {{ $selected }}>{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Precio</label>
                        <input type="number" class="form-control" id="precio" name="precio" value="{{ $info->precio }}" min="5000" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Estado</label>
                        <select class="form-select" name="estado" required>
                            @if (count($estados) > 0)
                                @foreach ($estados as $key => $item)
                                    @php
                                        $selected = ($info->estado == $key) ? 'selected' : '';
                                    @endphp
                                    <option value="{{ $key }}" {{ $selected }}>{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $info->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('cuartos.index') }}" class="btn btn-dark btn-sm">Regresar</a>
                        <button type="submit" class="btn btn-danger rounded btn-sm">Actualizar Información</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>

            $('#form_editar_informacion').on('submit', function(e) {
                event.preventDefault();
                if ($('#form_editar_informacion')[0].checkValidity() === false) {
                    event.stopPropagation();
                } else {

                    var url = route('cuartos.update');

                    //agregar data
                    var $thisForm = $('#form_editar_informacion');
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

                            location.href = route('cuartos.index');

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
                $('#form_editar_informacion').addClass('was-validated');
            });

        </script>
    </x-slot>

</x-app-layout>
