<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight text-center">
            {{ __('Gestión de Usuarios y Roles') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

                <div class="container text-center">
                    <div class="tabs-container">
                        <div class="row justify-content-center g-0 tabs-row">
                            <div class="col-6">
                                <div id="btnUsuarios" onclick="mostrarUsuarios()" class="tab-item active">
                                    Usuarios
                                </div>
                            </div>
                            @can('listar roles')
                            <div class="col-6">
                                <div id="btnRoles" onclick="mostrarRoles()" class="tab-item">
                                    Roles
                                </div>
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>

                <!-- Contenido de Usuarios -->
                <div id="seccionUsuarios" class="container">
                    <div class="container mb-4">
                        
                        <div class="row">
                            <div class="col text-end">
                                <a href="{{ route('usuarios.create') }}" class="btn btn-success">Nuevo Usuario</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Correo</th>
                                <th>Rol</th>
                                @if(auth()->user()->can('actualizar usuarios') || auth()->user()->can('eliminar usuarios'))
                                    <th>Acciones</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usuarios as $usuario)
                                <tr>
                                    <td>{{ $usuario->name }}</td>
                                    <td>{{ $usuario->email }}</td>
                                    <td>{{ $usuario->roles->pluck('name')->join(', ') }}</td>
                                    @if(auth()->user()->can('actualizar usuarios') || auth()->user()->can('eliminar usuarios'))
                                        <td>
                                            @can('actualizar usuarios')
                                                <a href="{{ route('usuarios.edit', $usuario->id) }}" class="btn btn-primary">Editar</a>
                                            @endcan
                                            @can('eliminar usuarios')
                                                <form action="{{ route('usuarios.destroy', $usuario->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('¿Estás seguro de eliminar este usuario?')">Eliminar</button>
                                                </form>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Contenido de Roles -->
                <div id="seccionRoles" class="container mt-4" style="display: none;">
                    <div class="container mb-4">
                        <div class="row">
                            <div class="col text-end">
                                <a href="{{ route('roles.create') }}" class="btn btn-success">Nuevo Rol</a>
                            </div>
                        </div>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nombre del Rol</th>
                                <th>Permisos</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $rol)
                                <tr>
                                    <td>{{ $rol->name }}</td>
                                    <td>{{ $rol->permissions->pluck('name')->join(', ') }}</td>
                                    <td>
                                        <a href="{{ route('roles.edit', $rol->id) }}" class="btn btn-primary">Editar</a>
                                        <form action="{{ route('roles.delete', $rol->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger" 
                                                    onclick="return confirm('¿Estás seguro de que deseas eliminar este rol?')">
                                                Eliminar
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script>
        function mostrarUsuarios() {
            document.getElementById("seccionUsuarios").style.display = "block";
            document.getElementById("seccionRoles").style.display = "none";
    
            document.getElementById("btnUsuarios").classList.add("active");
            document.getElementById("btnRoles").classList.remove("active");
        }
    
        function mostrarRoles() {
            document.getElementById("seccionUsuarios").style.display = "none";
            document.getElementById("seccionRoles").style.display = "block";
    
            document.getElementById("btnRoles").classList.add("active");
            document.getElementById("btnUsuarios").classList.remove("active");
        }
    </script>

    <style>
        .btn.active {
            background-color: #0b74cb;
            color: white;
        }

        .container {
            padding: 0 !important;
        }
        .tabs-container {
            margin-bottom: 20px;
            width: 100%;
        }
        .tabs-row {
            width: 100%;
            margin: 0;
        }
        .tab-item {
            border-radius: 5%;
            cursor: pointer;
            padding: 12px 20px;
            position: relative;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            width: 100%;
        }
        .tabs-row .col-6:first-child .tab-item.active {
            border-top: 2px solid #0b74cb;
            border-right: 2px solid #0b74cb;
            margin-right: -1px; /* Para evitar doble borde */
        }
        .tabs-row .col-6:nth-child(2) .tab-item:not(.active) {
            border-bottom: 2px solid #0b74cb;
            width: 100%;
        }
        .tabs-row .col-6:nth-child(2) .tab-item.active {
            border-top: 2px solid #0b74cb;
            border-left: 2px solid #0b74cb;
        }
        .tabs-row .col-6:first-child .tab-item:not(.active) {
            border-bottom: 2px solid #0b74cb;
            width: 100%;
        }
        .tab-item.active {
            background-color: #ffffff;
            color: #0b74cb;
            font-weight: 600;
        }
        .col-6 {
            padding: 0;
        }
        .justify-content-center {
            width: 100%;
            margin: 0;
        }
    </style>
</x-app-layout>
