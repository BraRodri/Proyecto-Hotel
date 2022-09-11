<x-app-layout>

    @section('pagina')Actualizar Rol y Permisos @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Configuración</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('roles.index') }}">Roles y Permisos</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Actualizar Rol y Permisos</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Actualizar Rol y Permisos</h1>
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
                        <input type="text" class="form-control" id="nombre" name="nombre" value="{{ $rol->name }}" required>
                    </div>

                    <div class="col-md-12">
                        <label for="" class="form-label">Permisos</label>
                        <select class="form-select" name="permisos[]" size="15" multiple required>
                            @if (count($permisos) > 0)
                                @foreach ($permisos as $item)
                                    @php
                                        $selected = '';
                                        foreach ($permisos_rol as $key => $value_p) {
                                            if($value_p->name == $item->name){
                                                $selected = 'selected';
                                            }
                                        }
                                    @endphp
                                    <option value="{{ $item->name }}" {{ $selected }}>{{ $item->name }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>

                    <input type="hidden" name="id" id="editar_id" value="{{ $rol->id }}">

                    <div class="col-12 pt-3">
                        <a href="{{ route('roles.index') }}" class="btn btn-dark btn-sm">Regresar</a>
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

                    var url = route('roles.update');

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

                            location.href = route('roles.index');

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
