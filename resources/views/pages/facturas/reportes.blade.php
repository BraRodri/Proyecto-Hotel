<x-app-layout>

    @section('pagina')Generación de Reportes @endsection

    <div class="container-fluid">

        <div class="mb-4 mt-3">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                  <li class="breadcrumb-item"><a href="{{ route('panel') }}">Inicio</a></li>
                  <li class="breadcrumb-item"><a href="{{ route('servicios.index') }}">Gestión de Servicios</a></li>
                  <li class="breadcrumb-item active" aria-current="page">Generación de Reportes</li>
                </ol>
            </nav>
        </div>

        <!-- Page Heading -->
        <div class="row mb-3">
            <div class="col-lg-12">
                <h1 class="h3 text-gray-800 flex-grow-1">Generación de Reportes</h1>
            </div>
        </div>

        <div class="card mb-4">
            <div class="card-header bg-gray-600">
                <i class="fas fa-table me-1"></i>
                Filtros
            </div>
            <div class="card-body">
                <form class="row" action="{{ route('facturas.reportes.generar') }}" method="POST" target="_blank">
                    @csrf
                    <div class="col-lg-6 col-12">
                        <label for="inputState" class="form-label">Cuartos:</label>
                        <select id="cuartos" class="form-select" name="cuartos">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($cuartos) > 0)
                                @foreach ($cuartos as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-6 col-12">
                        <label for="" class="form-label">Tipo de Ingreso</label>
                        <select id="tipo_ingreso" class="form-select" name="tipo_ingreso">
                            <option value="" selected>- Seleccione -</option>
                            @if (count($tipos_ingreso) > 0)
                                @foreach ($tipos_ingreso as $key => $item)
                                    <option value="{{ $item }}">{{ $item }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                    <div class="col-lg-4 col-12 mt-4">
                        <label for="" class="form-label">Fecha desde</label>
                        <input type="date" name="fecha_desde" class="form-control">
                    </div>
                    <div class="col-lg-4 col-12 mt-4">
                        <label for="" class="form-label">Fecha hasta</label>
                        <input type="date" name="fecha_hasta" class="form-control">
                    </div>
                    <div class="col-lg-4 col-12 mt-4">
                        <label for="" class="form-label">Acción</label> <br>
                        <button type="submit" class="btn btn-danger btn-sm btn-block">Generar Reporte</button>
                    </div>
                </form>
            </div>
        </div>

    </div>

    <x-slot name="js">
        <script>
            $('.select2').select2({
                minimumInputLength: 4,
                allowClear: true,
            });
        </script>
    </x-slot>

</x-app-layout>
