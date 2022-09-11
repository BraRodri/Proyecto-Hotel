<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand align-items-center justify-content-center" href="{{ route('panel') }}">
        <img src="{{ asset('images/LogoMotel_blanco.png') }}" class="img-fluid" width="90%"> <p></p>
        <div class="sidebar-brand-text pt-5">PANEL DE CONTROL</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Inicio -->
    <li class="nav-item {{ ! Route::is('panel') ?: 'active' }}">
        <a class="nav-link" href="{{ route('panel') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Inicio</span>
        </a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Usuarios -->
    @if(auth()->user()->can('Ver Usuarios'))
        <li class="nav-item {{ ! Route::is('usuarios.index') ?: 'active' }} {{ ! Route::is('clientes.index') ?: 'active' }} {{ ! Route::is('usuarios.reportes') ?: 'active' }} {{ ! Route::is('usuarios.identificacion') ?: 'active' }}">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseUsuarios"
                aria-expanded="true" aria-controls="collapseUsuarios">
                <i class="fa-solid fa-users"></i>
                <span>Gestión de Usuarios</span>
            </a>
            <div id="collapseUsuarios" class="collapse {{ ! Route::is('usuarios.index') ?: 'show' }} {{ ! Route::is('clientes.index') ?: 'show' }} {{ ! Route::is('usuarios.reportes') ?: 'show' }} {{ ! Route::is('usuarios.identificacion') ?: 'show' }}"  aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones:</h6>
                    @can('Ver Usuarios')
                        <a class="collapse-item {{ ! Route::is('usuarios.index') ?: 'active' }}" href="{{ route('usuarios.index') }}">
                            Usuarios
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Gestión de cuartos -->
    @if (auth()->user()->can('Ver Cuartos'))
        <li class="nav-item {{ ! Route::is('cuartos.index') ?: 'active' }}">
            <a class="nav-link" href="{{ route('cuartos.index') }}">
                <i class="fa-solid fa-house-user"></i>
                <span>Gestión de Cuartos</span>
            </a>
        </li>
    @endif

    <!-- gestión de Servicios -->
    @if(auth()->user()->can('Ver Servicios'))
        <li class="nav-item {{ ! Route::is('servicios.index') ?: 'active' }} {{ ! Route::is('servicios.reportes') ?: 'active' }} {{ ! Route::is('usuarios.reportes') ?: 'active' }} {{ ! Route::is('usuarios.identificacion') ?: 'active' }}">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseServicios"
                aria-expanded="true" aria-controls="collapseServicios">
                <i class="fa-solid fa-bell-concierge"></i>
                <span>Gestión de Servicios</span>
            </a>
            <div id="collapseServicios" class="collapse {{ ! Route::is('servicios.index') ?: 'show' }} {{ ! Route::is('servicios.reportes') ?: 'show' }} {{ ! Route::is('usuarios.reportes') ?: 'show' }} {{ ! Route::is('usuarios.identificacion') ?: 'show' }}"  aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones:</h6>
                    @can('Ver Servicios')
                        <a class="collapse-item {{ ! Route::is('servicios.index') ?: 'active' }}" href="{{ route('servicios.index') }}">
                            Servicios
                        </a>
                    @endcan
                    @can('Reportes de Servicios')
                        <a class="collapse-item {{ ! Route::is('servicios.reportes') ?: 'active' }}" href="{{ route('servicios.reportes') }}">
                            Reportes
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Facturas -->
    @if(auth()->user()->can('Ver Facturas') || auth()->user()->can('Reportes de Facturas'))
        <li class="nav-item {{ ! Route::is('facturas.index') ?: 'active' }} {{ ! Route::is('facturas.reportes') ?: 'active' }} {{ ! Route::is('usuarios.reportes') ?: 'active' }} {{ ! Route::is('usuarios.identificacion') ?: 'active' }}">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseFacturas"
                aria-expanded="true" aria-controls="collapseFacturas">
                <i class="fa-solid fa-receipt"></i>
                <span>Facturas</span>
            </a>
            <div id="collapseFacturas" class="collapse {{ ! Route::is('facturas.index') ?: 'show' }} {{ ! Route::is('facturas.reportes') ?: 'show' }} {{ ! Route::is('usuarios.reportes') ?: 'show' }} {{ ! Route::is('usuarios.identificacion') ?: 'show' }}"  aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones:</h6>
                    @can('Ver Facturas')
                        <a class="collapse-item {{ ! Route::is('facturas.index') ?: 'active' }}" href="{{ route('facturas.index') }}">
                            Facturas
                        </a>
                    @endcan
                    @can('Reportes de Facturas')
                        <a class="collapse-item {{ ! Route::is('facturas.reportes') ?: 'active' }}" href="{{ route('facturas.reportes') }}">
                            Reportes
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Configuración -->
    @if(auth()->user()->can('Ver Roles y Permisos') || auth()->user()->can('Ver Tipos Servicios'))
        <li class="nav-item {{ ! Route::is('roles.index') ?: 'active' }} {{ ! Route::is('tipos_servicios.index') ?: 'active' }}">
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTwo"
                aria-expanded="true" aria-controls="collapseTwo">
                <i class="fa-solid fa-gear"></i>
                <span>Configuración</span>
            </a>
            <div id="collapseTwo" class="collapse {{ ! Route::is('roles.index') ?: 'show' }} {{ ! Route::is('sedes.index') ?: 'show' }}" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Opciones:</h6>
                    @can('Ver Roles y Permisos')
                        <a class="collapse-item {{ ! Route::is('roles.index') ?: 'active' }}" href="{{ route('roles.index') }}">
                            Roles y Permisos
                        </a>
                    @endcan
                    @can('Ver Tipos Servicios')
                        <a class="collapse-item {{ ! Route::is('tipos_servicios.index') ?: 'active' }}" href="{{ route('tipos_servicios.index') }}">
                            Tipos Servicios
                        </a>
                    @endcan
                </div>
            </div>
        </li>
    @endif

    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
